<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
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
     * @param array $overrides Campos para sobrescrever os valores padrão.
     * @return \App\Models\User O usuário criado.
     */
    private function criaUsuario(array $overrides = [])
    {
        return User::factory()->create(array_merge([
            'id_perfil' => 3,
            'id_sexo'   => 7,
            'nome'      => 'Usuário Padrão',
            'cpf'       => '12345678910',
            'senha'     => bcrypt('12345678'),
            'email'     => 'teste@example.com',
            'dat_nasc'  => '1990-01-01',
            'endereco'  => 'Rua Teste',
        ], $overrides));
    }

    /**
     * Testa login com credenciais válidas.
     *
     * Verifica se o sistema retorna status 200 e um token de acesso
     * quando as credenciais corretas são fornecidas.
     *
     * @return void
     */
    public function testLoginValido()
    {

        $this->criaUsuario();

        $response = $this->postJson('/api/login', [
            'cpf'    => '12345678910',
            'senha' => '12345678',
        ]);

        $response->assertStatus(self::HTTP::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * Testa login quando o CPF informado não existe.
     *
     * Verifica se o sistema retorna status 404 ao tentar autenticar
     * com um CPF inexistente.
     *
     * @return void
     */
    public function testLoginCpfNaoExiste()
    {
        $response = $this->postJson('/api/login', [
            'cpf'   => '99999999999',
            'senha' => 'qualquer',
        ]);

        $response->assertStatus(self::HTTP::HTTP_NOT_FOUND);
    }

    /**
     * Testa login com senha incorreta.
     *
     * Verifica se o sistema retorna status 401 quando a senha fornecida
     * não corresponde à do usuário.
     *
     * @return void
     */
    public function testLoginSenhaIncorreta()
    {
        $this->criaUsuario([
            'cpf'   => '12345678910',
            'senha' => bcrypt('senha_certa'),
        ]);

        $response = $this->postJson('/api/login', [
            'cpf'   => '12345678910',
            'senha' => 'senha_errada',
        ]);

        $response->assertStatus(self::HTTP::HTTP_UNAUTHORIZED);
    }

    /**
     * Testa login com usuário desativado.
     *
     * Verifica se o sistema retorna status 403 quando o usuário
     * está marcado como desativado (soft delete).
     *
     * @return void
     */
    public function testLoginUsuarioDesativado()
    {
        $this->criaUsuario([
            'cpf'        => '22233344455',
            'senha'      => bcrypt('senha123'),
            'deleted_at' => now(),
        ]);

        $response = $this->postJson('/api/login', [
            'cpf'   => '22233344455',
            'senha' => 'senha123',
        ]);

        $response->assertStatus(self::HTTP::HTTP_FORBIDDEN);
    }

    /**
     * Testa acesso a rota protegida sem token.
     *
     * Verifica se o sistema retorna status 401 quando uma rota protegida
     * é acessada sem fornecer o token JWT.
     *
     * @return void
     */
    public function testAcessoSemToken()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(self::HTTP::HTTP_UNAUTHORIZED);
    }

    /**
     * Testa acesso a rota protegida com token válido.
     *
     * Cria um usuário válido, realiza login para obter o token
     * e acessa uma rota protegida verificando que retorna status 200.
     *
     * @return void
     */
    public function testAcessoComTokenValido()
    {

        $this->criaUsuario([
            'cpf'   => '12345678910',
            'senha' => bcrypt('12345678'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'cpf'    => '12345678910',
            'senha' => '12345678',
        ]);

        $token = $loginResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/me');

        $response->assertStatus(self::HTTP::HTTP_OK);
    }
}
