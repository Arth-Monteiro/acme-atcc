<!-- https://medium.com/@vhsilva.ap/configurando-laravel-6-nginx-e-postgresql-com-docker-9ad29c53d5 -->

# ACME - ATCC
Projeto de Conclusão de Curso da Turma de Engenharia da Computação da Universidade São Judas Tadeu (USJT)

## Inicialização do Projeto
### Requerimentos
- Docker [^20.10] - [Download](https://docs.docker.com/engine/install/)
- Docker Compose [^2.11.2] - [Download](https://docs.docker.com/compose/install/)
- PHP [^8.1] - [Download](https://www.php.net/downloads.php)
  -  php-xml  php-curl 
- Composer [^2.3.10]- [Download](https://getcomposer.org/doc/00-intro.md)
- Node [^16.16] - [Download](https://nodejs.org/en/download/)

### Init
1. Clone o Projeto para sua máquina local 
2. Dê permissão no diretório `storage`:
   1. Linux: `sudo chmod o+w ./atcc-laravel/storage/ -R`
   2. Windows (se necessário): [aqui](https://answers.microsoft.com/en-us/windows/forum/all/give-permissions-to-files-and-folders-in-windows/78ee562c-a21f-4a32-8691-73aac1415373)
3. Inicie os containers pela primeira vez `docker-compose up -d`
4. Acesse o diretório `atcc-laravel`
5. Rode o comando `composer update` para instalar as dependências
6. Rode o comando `npm install` para instalar dependências
7. Rode o comando `npm run dev` para buildar
8. Rode o comando `composer migrate` para finalizar a criação das tabelas no banco de dados
9. Ao fim do processo, deverá ser possível acessar o projeto em http://localhost:8000/login

### Considerações
- Sempre que necessário criar um model, use o comando `composer make-model NomeModel`
- Quando necessário criar uma atualização no banco de dados, use o comando `composer make-migration nome_explicativo_da_alteracao`
- Para rodar a atualização do banco de dados criado acima, o comando `composer migrate`
- Caso necessário dar rollback da atualização do banco de dados, use o comando `composer migrate-rollback`
- Quando necessário buildar o projeto `npm run dev`

### Debug - [Passo a passo](https://5balloons.info/setting-up-xdebug-using-laravel-valet-and-vscode/) 
Utilizando o [XDebug](https://xdebug.org/docs/install#windows)

Instale Chrome Extension [aqui](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc)

Instale a extensão do VsCode ["PHP Debug"](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)
 
Adicione ao launch.json
```
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    "version": "0.2.0",
    "configurations": [{
        "type": "php",
        "request": "launch",
        "name": "docker",
        "port": 9001,
        "stopOnEntry": false,
        "pathMappings": {
            "/var/www/html": "${workspaceRoot}",
        }
    }]
}
```

### Metabase
Pode ser acessado via http://localhost:3000/
User: super.admin@acme.com
Senha: Senha@123!
