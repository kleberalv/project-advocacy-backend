<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

/**
 * Classe responsável por fornecer serviços relacionados aos usuários.
 */
class UserService
{
    /**
     * Repositório de usuário.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Cria uma nova instância do serviço.
     *
     * @param UserRepository $userRepository O repositório de usuário.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Valida os dados de entrada do usuário.
     *
     * @param array $filledFields Os dados do usuário a serem validados.
     * @return array A resposta de erro em caso de validação falha.
     */
    public function validateUserInput($filledFields)
    {
        $filledFields = Helper::formatCPF($filledFields);
        $rules = [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:tab_usuarios,cpf,' . ($filledFields['id'] ?? 'null') . ',id_usuario',
            'senha' => 'string|min:8|max:20',
            'email' => 'required|string|email|max:255',
            'dat_nasc' => 'required|date',
            'id_perfil' => 'required|integer',
            'id_sexo' => 'required|integer',
            'endereco' => 'required|string|max:255',
        ];
        $customMessages = [
            '*' => [
                'required' => 'O campo :attribute é obrigatório',
                'min' => 'O campo :attribute deve conter no mínimo :min caracteres',
                'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            ],
            'cpf.unique' => 'Este CPF já está cadastrado para outro usuário',
            'senha.string' => 'O campo senha deve ser uma string',
            'senha.min' => 'O campo senha deve conter no mínimo :min caracteres',
            'senha.max' => 'O campo senha deve conter no máximo :max caracteres',
        ];
        $validator = Validator::make($filledFields, $rules, $customMessages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = 'Ocorreu o seguinte erro na operação: ';
            foreach ($errors as $index => $error) {
                $errorMessage .= $error;
                if ($index < count($errors) - 1) {
                    $errorMessage .= ', ';
                } else {
                    $errorMessage .= '.';
                }
            }
            return [
                'message' => $errorMessage,
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];
        }
        return;
    }

    /**
     * Cria uma senha segura para o usuário.
     *
     * @param array $data Os dados do usuário.
     * @return array Os dados do usuário com a senha criptografada.
     */
    private function senhaUser($formattedUser)
    {
        $senha = isset($formattedUser['senha']) ? Hash::make($formattedUser['senha']) : Hash::make('PrimeiroAcesso2023');
        $formattedUser['senha'] = $senha;
        return $formattedUser;
    }

    /**
     * Valida o usuário para exclusão e realiza a exclusão lógica.
     *
     * @param array $user Os dados do usuário a serem validados e excluídos.
     * @return mixed O usuário excluído.
     *
     * @return array Se o usuário não for encontrado.
     */
    public function validateUserToDelete($user)
    {
        $userToDelete = $this->userRepository->getUserById($user);
        if (!$userToDelete) {
            return [
                'message' => 'Usuário não encontrado',
                'status' => Response::HTTP_NOT_FOUND,
            ];
        }
        $this->deleteUser($userToDelete);
        return;
    }

    /**
     * Retorna a lista de usuários.
     *
     * @return array A lista de usuários e o status da resposta.
     */
    public function getIndex()
    {
        $users = $this->userRepository->getIndex();
        return [
            'users' => $users,
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Retorna a lista de advogados.
     *
     * @return array A lista de advogados e o status da resposta.
     */
    public function getLawyer()
    {
        $lawyer = $this->userRepository->getLawyer();
        return [
            'lawyer' => $lawyer,
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Retorna a lista de clientes.
     *
     * @return array A lista de clientes e o status da resposta.
     */
    public function getClient()
    {
        $client = $this->userRepository->getClient();
        return [
            'client' => $client,
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $user Os dados do novo usuário.
     * @return array A mensagem de sucesso e o status da resposta.
     */
    public function createUser($request)
    {
        $formattedUser  = Helper::formatCPF($request);
        $userToCreate = $this->senhaUser($formattedUser);
        $this->userRepository->createUser($userToCreate);
        return [
            'message' => 'Usuário criado com sucesso!',
            'status' => Response::HTTP_CREATED
        ];
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param array $user Os dados do usuário a serem atualizados.
     * @return mixed O usuário atualizado.
     * 
     * @return array Se o usuário não for encontrado.
     */
    public function updateUser($request)
    {
        $request = Helper::formatCPF($request);
        $userToUpdate = $this->userRepository->getUserByCpf($request);
        if (!$userToUpdate) {
            return [
                'message' => 'Não foi encontrado um usuário com o CPF informado',
                'status' => Response::HTTP_NOT_FOUND,
            ];
        }
        if (isset($request['senha'])) {
            $request = $this->senhaUser($request);
        }
        $this->userRepository->updateUser($request, $userToUpdate);
        return;
    }

    /**
     * Exclui logicamente um usuário.
     *
     * @param mixed $user O usuário a ser excluído.
     * @return array A mensagem de sucesso ou erro e o status da resposta.
     * 
     * @return array Se o usuário tentar excluir a própia conta.
     */
    public function deleteUser($user)
    {
        $usuarioAtual = Auth::user();
        if ($usuarioAtual->id_usuario === $user['id_usuario']) {
            return [
                'message' => 'Não é possível excluir a sua própria conta de usuário',
                'status' => Response::HTTP_FORBIDDEN,
            ];
        }
        $this->userRepository->deleteUser((object)$user);
        return [
            'message' => 'Usuário excluído com sucesso!',
            'status' => Response::HTTP_OK
        ];
    }
}
