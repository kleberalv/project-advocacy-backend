# Projeto de advocacia
Projeto de advocacia para fins de estudos. Há a possibilidade do projeto ir a produção.

## Descrição
Este projeto consiste em uma infraestrutura de contêineres que abrange cinco componentes interligados, permitindo a hospedagem e execução de um aplicativo completo. Cada contêiner desempenha um papel específico na arquitetura geral do sistema, proporcionando uma experiência de desenvolvimento e implantação coesa e eficaz.

Aqui está uma visão detalhada de cada contêiner:

1. app:

Este contêiner é responsável por hospedar a aplicação principal desenvolvida em PHP. Ele é construído a partir de um Dockerfile personalizado que foi configurado para operar em conjunto com o servidor PHP. O uso do Xdebug facilita as atividades de desenvolvimento e depuração, tornando o processo mais eficiente.

2. db:

O contêiner MariaDB é dedicado ao armazenamento dos dados do aplicativo. Ele oferece um ambiente seguro para a persistência de informações cruciais, como tabelas e registros. A presença desse contêiner é fundamental para garantir o funcionamento correto e a integridade dos dados.

3. phpmyadmin:

Este contêiner hospeda uma interface web do phpMyAdmin, uma ferramenta de administração de banco de dados. Através dele, é possível interagir com o banco de dados MariaDB de maneira intuitiva e conveniente, facilitando tarefas administrativas e manipulação de dados.

4. nginx:

Atuando como servidor web, o contêiner Nginx direciona as solicitações HTTP para a aplicação PHP. Além disso, ele proporciona uma camada extra de segurança e otimização de desempenho, contribuindo para uma experiência de usuário mais eficiente e segura.

5. frontend:

Este contêiner é encarregado de hospedar a camada frontal (frontend) do aplicativo. Construído a partir do código-fonte do projeto de frontend, ele inicia um ambiente de desenvolvimento para a interface do usuário, utilizando ferramentas como o npm. Para configurar esse contêiner, é importante garantir que o frontend (project-advocacy-frontend) esteja localizado na mesma pasta deste projeto.

## Licença

Este projeto é licenciado sob a [Licença MIT](LICENSE). Consulte o arquivo [LICENSE](LICENSE) para obter mais detalhes.

### Uso Permitido

Você está autorizado a utilizar este código-fonte apenas para fins de estudo e aprendizado. Isso inclui a análise, modificação e execução do software, desde que seja para fins educacionais e não comerciais.

### Restrições de Uso

Este projeto contém informações e dados reais relacionados ao domínio da advocacia e a um advogado real. Portanto, o uso, distribuição ou divulgação das informações contidas no back-end e no front-end são estritamente restritos. Você não tem permissão para usar, reproduzir ou compartilhar essas informações reais para qualquer finalidade.

### Responsabilidade

O autor deste projeto não assume nenhuma responsabilidade pelo uso indevido ou violação dos termos de licença. Você é o único responsável por garantir o uso adequado e ético deste código-fonte.

### Isenção de Garantia

Este projeto é fornecido "no estado em que se encontra", sem garantias de qualquer tipo. O autor não se responsabiliza por quaisquer danos ou consequências decorrentes do uso deste software.

## Instruções

Siga as etapas abaixo para configurar e executar o projeto:

1. Clone o repositório do project-advocacy-backend;

2. Abra um terminal e navegue até o diretório project-advocacy-backend;

3. Copie os dados do arquivo .env.example, crie um arquivo na raiz do projeto chamado .env e cole dentro dele os dados presentes em .env.example;

4. Execute o seguinte comando para construir e iniciar os contêineres:
`docker-compose up -d --build`;

5. Após o download e a criação dos contêineres, acesse o contêiner app através do terminal:
`docker exec -it application-server-app /bin/bash`;

6. Dentro do contêiner app, execute os seguintes comandos:
`composer install`,
`php artisan migrate` e 
`php artisan db:seed`;

7. Pronto, a API está pronta para ser utilizada pela URL http://localhost:8080/;

8. Caso tenha intersse em roda-la em conjunto com o frontend em react, basta acessar e ler o README.md do [project-advocacy-frontend](https://github.com/kleberalv/project-advocacy-frontend/blob/master/README.md).

## Tecnologias utilizadas
<div align="left">
    <img align="center" alt="PHP" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white">
    <img align="center" alt="Laravel" src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
    <img align="center" alt="Xdebug" src="https://img.shields.io/badge/Xdebug-DB1F29?style=for-the-badge&logo=xdebug&logoColor=white">
    <img align="center" alt="React" src="https://img.shields.io/badge/React-61DAFB?style=for-the-badge&logo=react&logoColor=black">
    <img align="center" alt="JavaScript" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black">
    <img align="center" alt="Axios" src="https://img.shields.io/badge/Axios-005571?style=for-the-badge&logo=axios&logoColor=white">
    <img align="center" alt="API REST" src="https://img.shields.io/badge/API_REST-009688?style=for-the-badge">
</div>

## Ferramentas de desenvolvimento utilizadas
<div align="left">
    <img align="center" alt="Docker" src="https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white"> 
    <img align="center" alt="Composer" src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white">
    <img align="center" alt="MariaDB" src="https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white">
    <img align="center" alt="phpMyAdmin" src="https://img.shields.io/badge/phpMyAdmin-4479A1?style=for-the-badge&logo=phpmyadmin&logoColor=white">
    <img align="center" alt="Postman" src="https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=postman&logoColor=white">
</div>

# Copyright ©
Copyright © Developed by: Kleber Alves Bezerera Junior - Sênior Developer 2025.