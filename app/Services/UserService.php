<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Http\Response;
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
     * @param array $data Os dados do usuário a serem validados.
     * @return array A resposta de erro em caso de validação falha.
     */
    public function validateUserInput($data)
    {
        $data = Helper::formatCPF($data);
        $rules = [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:tab_usuarios,cpf,' . ($data['id'] ?? 'null') . ',id_usuario',
            'senha' => 'string|min:8|max:20',
            'email' => 'required|string|email|max:255',
            'dat_nasc' => 'required|date',
            'id_perfil' => 'required|integer',
            'endereco' => 'required|string|max:255',
        ];
        $customMessages = [
            '*' => [
                'required' => 'O campo :attribute é obrigatório',
                'min' => 'O campo :attribute deve conter no mínimo :min caracteres',
                'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            ],
            'cpf.unique' => 'Este CPF já está cadastrado para outro usuário',
        ];
        $validator = Validator::make($data, $rules, $customMessages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = 'Ocorreu o seguinte erro na operação: ' . implode(', ', $errors);

            return response()->json([
                'message' => $errorMessage,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return;
    }

    /**
     * Cria uma senha segura para o usuário.
     *
     * @param array $data Os dados do usuário.
     * @return array Os dados do usuário com a senha criptografada.
     */
    private function senhaUser($data)
    {
        $senha = isset($data['senha']) ? Hash::make($data['senha']) : Hash::make('PrimeiroAcesso2023');
        $data['senha'] = $senha;
        return $data;
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
        $UserToDelete = $this->userRepository->getUserById($user);
        if (!$UserToDelete) {
            return response()->json(
                [
                    'errors' => "Usuário não encontrado"
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->deleteUser($UserToDelete);
    }

    /**
     * Retorna a lista de usuários.
     *
     * @return \Illuminate\Database\Eloquent\Collection A lista de usuários.
     */
    public function getIndex()
    {
        $users = $this->userRepository->getIndex();
        return $users;
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $user Os dados do novo usuário.
     * @return mixed O usuário criado.
     */
    public function createUser($user)
    {
        $data = Helper::formatCPF($user);
        $dados = $this->senhaUser($data);
        return $this->userRepository->createUser($dados);
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param array $user Os dados do usuário a serem atualizados.
     * @return mixed O usuário atualizado.
     * 
     * @return array Se o usuário não for encontrado
     */
    public function updateUser($user)
    {
        $user = Helper::formatCPF($user);
        $userToUpdate = $this->userRepository->getUserByCpf($user);
        if (!$userToUpdate) {
            return response()->json(
                [
                    'errors' => "Não foi encontrado um usuário com o CPF informado"
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        if (isset($user['senha'])) {
            $user = $this->senhaUser($user);
        }
        return $this->userRepository->updateUser($user, $userToUpdate);
    }

    /**
     * Exclui logicamente um usuário.
     *
     * @param mixed $user O usuário a ser excluído.
     * @return mixed O usuário excluído.
     * 
     * @return array Se o usuário tentar excluir a própia conta
     */
    public function deleteUser($user)
    {
        $usuarioAtual = Auth::user();
        if ($usuarioAtual->id_usuario === $user['id_usuario']) {
            return response()->json(
                [
                    'errors' => "Não é possível excluir a sua própia conta de usuário"
                ],
                Response::HTTP_FORBIDDEN
            );
        }
        return $user = $this->userRepository->deleteUser((object)$user);
    }
}
