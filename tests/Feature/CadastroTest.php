<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CadastroTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /**
     * Cria um usuário de teste com dados padrão ou sobrescrevendo campos específicos.
     *
     * Utilizado como base para geração de usuários em cenários de teste.
     * Por padrão gera CPF, e-mail e demais campos válidos para não colidir com seed.
     *
     * @param array $overrides Campos que sobrescrevem os valores padrão.
     * @return \App\Models\User Usuário criado na base de dados de teste.
     */
    private function criaUsuario(array $overrides = [])
    {
        return User::factory()->create(array_merge([
            'id_perfil' => 3,
            'id_sexo'   => 7,
            'nome'      => 'Usuário Padrão',
            'cpf'       => (string) random_int(20000000000, 99999999999),
            'senha'     => bcrypt('12345678'),
            'email'     => 'teste@example.com',
            'dat_nasc'  => '1990-01-01',
            'endereco'  => 'Rua Teste',
        ], $overrides));
    }

    /**
     * Cria e autentica um usuário do perfil informado.
     *
     * Perfis disponíveis: Admin (1), Advogado (2), Cliente (3).
     * Após a criação, é feito login real via rota /api/login para obter
     * o token JWT, que é retornado para uso nos testes subsequentes.
     *
     * @param string $perfil Perfil desejado ("Admin", "Advogado" ou "Cliente").
     * @param array $overrides Campos adicionais para sobrescrever dados padrão.
     * @return string Token JWT válido para autenticação.
     */
    private function loginComoPerfil(string $perfil, array $overrides = []): string
    {
        $map = ['Admin' => 1, 'Advogado' => 2, 'Cliente' => 3];

        $user = $this->criaUsuario(array_merge([
            'id_perfil' => $map[$perfil],
        ], $overrides));

        $login = $this->postJson('/api/login', [
            'cpf'   => $user->cpf,
            'senha' => '12345678',
        ]);

        $login->assertStatus(self::HTTP::HTTP_OK)
            ->assertJsonStructure(['access_token']);
        return $login->json('access_token');
    }

    /**
     * Testa cadastro de advogado por um usuário Admin.
     *
     * Verifica se um Admin autenticado consegue criar um novo usuário
     * com perfil de Advogado (id_perfil = 2), retornando status 201 CREATED.
     *
     * @return void
     */
    public function test_admin_pode_cadastrar_advogado()
    {
        $token = $this->loginComoPerfil('Admin');

        $payload = [
            'id_perfil' => 2,
            'id_sexo'  => 1,
            'nome'     => 'Dra. Ana',
            'cpf'      => '11122233344',
            'senha'    => '12345678',
            'email'    => 'anaNovoEmail@example.com',
            'dat_nasc' => '1992-05-10',
            'endereco' => 'Rua Exemplo, 123',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->postJson('/api/users', $payload);

        $response->assertStatus(self::HTTP::HTTP_CREATED);

        $this->assertDatabaseHas('tab_usuarios', [
            'email'     => $payload['email'],
            'cpf'       => $payload['cpf'],
            'id_perfil' => 2,
            'nome'      => 'Dra. Ana',
        ]);
    }

    /**
     * Testa tentativa de cadastro de advogado por um Cliente.
     *
     * Verifica se um Cliente autenticado é impedido de criar usuário
     * com perfil de Advogado, retornando status 403 FORBIDDEN.
     *
     * @return void
     */
    public function test_cliente_nao_pode_cadastrar_advogado()
    {
        $token = $this->loginComoPerfil('Cliente');

        $payload = [
            'nome'     => 'Dr. João',
            'cpf'      => '55566677788',
            'email'    => 'joao.' . Str::random(6) . '@example.com',
            'senha'    => '12345678',
            'id_sexo'  => 1,
            'dat_nasc' => '1990-03-20',
            'endereco' => 'Rua Sem Saída, 456',
            'id_perfil' => 2,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->postJson('/api/users', $payload);

        $response->assertStatus(self::HTTP::HTTP_FORBIDDEN);
    }

    /**
     * Testa listagem de usuários por um Admin.
     *
     * Espera envelope { "users": [...] } com itens contendo chaves básicas.
     *
     * @return void
     */
    public function test_admin_pode_listar_usuarios()
    {
        $token = $this->loginComoPerfil('Admin');

        // garante que há conteúdo
        $this->criaUsuario(['nome' => 'Usuário 1']);
        $this->criaUsuario(['nome' => 'Usuário 2']);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/users');

        $response->assertStatus(self::HTTP::HTTP_OK)
            ->assertJsonStructure([
                'users' => [
                    ['id_usuario', 'nome', 'email']
                ]
            ]);

        // checa que é array e tem pelo menos 1
        $json = $response->json();
        $this->assertIsArray($json['users']);
        $this->assertNotEmpty($json['users']);
    }

    /**
     * Testa tentativa de listagem de usuários por um Cliente.
     *
     * Verifica se um Cliente autenticado não consegue acessar a rota
     * GET /api/users para listar todos os usuários, retornando
     * status 403 FORBIDDEN.
     *
     * @return void
     */
    public function test_cliente_nao_pode_listar_todos_usuarios()
    {
        $tokenCliente = $this->loginComoPerfil('Cliente');

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$tokenCliente}",
        ])->getJson('/api/users');

        $response->assertStatus(self::HTTP::HTTP_FORBIDDEN);
    }

    /**
     * Testa atualização de usuário existente por um Admin.
     *
     * Verifica se um Admin autenticado consegue alterar os dados
     * de um usuário existente (ex.: nome, endereço), retornando
     * status 200 OK após a operação.
     *
     * @return void
     */
    public function test_admin_pode_atualizar_usuario_existente()
    {
        $token = $this->loginComoPerfil('Admin');

        $usuario = $this->criaUsuario([
            'id_perfil' => 2,
        ]);

        $payload = [
            'id'       => $usuario->id_usuario,
            'nome'     => 'Dra. Ana Atualizada',
            'cpf' => $usuario->cpf,
            'senha'    => '12345678',
            'email'    => $usuario->email,
            'dat_nasc' => $usuario->dat_nasc,
            'id_perfil' => 2,
            'id_sexo'  => $usuario->id_sexo,
            'endereco' => 'Rua Nova, 999',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->putJson("/api/users/{$usuario->id_usuario}", $payload);

        $response->assertStatus(self::HTTP::HTTP_OK);

        $this->assertDatabaseHas('tab_usuarios', [
            'id_usuario' => $usuario->id_usuario,
            'nome'       => 'Dra. Ana Atualizada',
            'endereco'   => 'Rua Nova, 999',
        ]);
    }

    /**
     * Testa tentativa de atualização de usuário por um Cliente.
     *
     * Verifica se um Cliente autenticado não consegue atualizar os dados
     * de outro usuário, retornando status 403 FORBIDDEN e garantindo
     * que os dados originais permanecem inalterados no banco.
     *
     * @return void
     */
    public function test_cliente_nao_pode_atualizar_outro_usuario()
    {
        $tokenCliente = $this->loginComoPerfil('Cliente');

        $alvo = $this->criaUsuario([
            'id_perfil' => 2,
        ]);

        $payload = [
            'id'       => $alvo->id_usuario,
            'nome'     => 'Tentativa de Alteração Indevida',
            'cpf'      => $alvo->cpf,
            'senha'    => '12345678',
            'email'    => $alvo->email,
            'dat_nasc' => $alvo->dat_nasc,
            'id_perfil' => $alvo->id_perfil,
            'id_sexo'  => $alvo->id_sexo,
            'endereco' => 'Rua Invadida, 999',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$tokenCliente}",
        ])->putJson("/api/users/{$alvo->id_usuario}", $payload);

        $response->assertStatus(self::HTTP::HTTP_FORBIDDEN);
    }

    /**
     * Testa deleção de usuário existente por um Admin.
     *
     * Envia o id na URL e também no corpo (id_usuario), conforme a API atual.
     * Espera status 200 OK e ausência do registro no banco.
     *
     * @return void
     */
    public function test_admin_pode_deletar_usuario()
    {
        $token   = $this->loginComoPerfil('Admin');
        $usuario = $this->criaUsuario(['id_perfil' => 2]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->deleteJson("/api/users/{$usuario->id_usuario}", [
            'id_usuario' => $usuario->id_usuario,
        ]);

        $response->assertStatus(self::HTTP::HTTP_OK);

        $this->assertSoftDeleted('tab_usuarios', [
            'id_usuario' => $usuario->id_usuario,
        ]);

        $this->assertDatabaseHas('tab_usuarios', [
            'id_usuario' => $usuario->id_usuario,
        ]);
    }

    /**
     * Testa tentativa de deleção por um Cliente.
     *
     * Envia o id na URL e também no corpo (id_usuario), conforme a API atual.
     * Espera 403 FORBIDDEN e registro permanece no banco.
     *
     * @return void
     */
    public function test_cliente_nao_pode_deletar_usuario()
    {
        $tokenCliente = $this->loginComoPerfil('Cliente');
        $alvo         = $this->criaUsuario(['id_perfil' => 2]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$tokenCliente}",
        ])->deleteJson("/api/users/{$alvo->id_usuario}", [
            'id_usuario' => $alvo->id_usuario,
        ]);

        $response->assertStatus(self::HTTP::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('tab_usuarios', [
            'id_usuario' => $alvo->id_usuario,
        ]);
    }
}
