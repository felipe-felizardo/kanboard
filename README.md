# Kanboard SCI

### Kanboard é um software de gerenciamento de projetos que se concentra na metodologia Kanban.

## Docker
| Tag     | Descrição                                       |
| ------- | ----------------------------------------------- |
| ``dev`` | Imagem utilizada no ambiente de desenvolvimento |
| ``sci`` | Imagem de produção                              |

### Rodando os containers
#### Container de produção:
```console 
foo@bar:~$ docker run  --name=kanboard-sci --rm -d -p 443:443/tcp -p 80:80/tcp felipefelizardo/kanboard:sci;
```
#### Containers de desenvolvimento (docker compose):
```console 
foo@bar:~$ docker build --pull --rm -f "Dockerfile-dev.yml" -t felipefelizardo/kanboard:dev "."
foo@bar:~$ docker-compose -f "docker-compose.yml" up -d --build
```
Contém:
- ``kanboard:dev``
- ``mysql:5.7``
- ``phpmyadmin:latest``

[Docker Hub](https://hub.docker.com/repository/docker/felipefelizardo/kanboard)

## Config File
- Config utilizado no ambiente de desenvolvimento deve ficar em ``./config.php``
- Config que é utilizado no container de produção fica em: ``./docker/var/www/app/config.php``

## Volumes
| Caminho                  | Descrição                                     |
| -----------------------  | --------------------------------------------- |
| ``/var/www/app/data``    | Dados da (Sqlite database, attachments, etc.) |
| ``/var/www/app/plugins`` | Plugins                                       |
| ``/etc/nginx/ssl``       | Certificados SSL                              |

## Banco de dados
O Kanboard suporta os seguintes banco de dados:
- SQLite
- MySQL
- PostgreSQL

O Kanboard SCI utiliza o **MySQL em produção e desenvolvimento**, porém o SQLite pode ser utilizado localmente para a execução de testes unitários.

#### Criar novo banco de dados (MySQL)
```sql 
CREATE DATABASE kanboard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Depois basta conectar ao localhost:80 que a criação de tabelas e migrações serão executadas.

#### Migrações:
- Migrações de SQL são executadas automaticamente quando você atualiza Kanboard para uma nova versão
- Para Postgres e Mysql, o número da versão do schema atual é armazenado na ```tabela schema_version``` e para Sqlite é armazenado na variável ```user_version```
- As migrações são definidas no arquivo ```app / Schema / <DatabaseType> .php```
- Cada função é uma migração
- Cada migração é executada em uma transação
- Se a migração gerar um erro, um rollback é executado
    
## Padrões de código    
#### PHP
- Indentação: 4 espaços
- Line return: Unix => ```\n```
- Encoding: ```UTF-8```
- Usar apenas as tags de abertura ```<?php``` ou ```<?=``` para templates, nunca usar ```<?```
- Sempre escrever comentários PHPdoc para métodos e propriedades de classes
- Estilo de código: [PSR-1](https://www.php-fig.org/psr/psr-1/) and  [PSR-2](https://www.php-fig.org/psr/psr-2/)

#### JavaScript
- Indentação: 4 spaces
- Line return: Unix => ```\n```

#### CSS
- Indentação: 4 spaces
- Line return: Unix => ```\n```

## Linguagem
A linguagem do Kanboard é originalmente em inglês, **o Kanboard SCI deve seguir o padrão e continuar com a linguagem padrão como o inglês**, isso significa que todas funções, variáveis, etc devem estar na lingua inglesa.
#### Tradução
- Traduções estão no diretório ```./app/Locale```
- Existe um subdiretório para cada linguagem, a pt-br está em ```./app/Locale/pt_BR/translations.php```
```translations.php``` é um arquivo ```PHP``` que retorna um ```Array``` de chave-valor
- A chave é o texto original em inglês, e o value é a tradução

#### Funções de tradução
A tradução é exibida utilizando as seguintes funções no código fonte:
```t()```: exibe o valor com HTML escaping
```e()```: exibe o valor sem HTML escaping

As funções citadas utilizam ```sprintf()``` para substituir elementos:
```%s``` é utilizado para substituir string
```%d``` é utilizado para substituir string

## Greenwing
O Kanboard SCI utilizou como base de UI o plugin [Greenwing](https://github.com/Confexion/Greenwing/)

#### Modificações
Verificar se o node, npm, e npx estão instalados executando ```node --version```, ```npm --version``` e ```npx --version```

Instalar ```gulp``` globalmente: ```npm install --global gulp```

Checar se gulp está instalado ```gulp --version```

Ir no diretório ```./plugins/Greenwing```

Copiar todos os arquivos da pasta ```edit``` para o diretório ```Greenwing```

Executar ```npm install``` ou ```yarn install```

Editar ```gulpfile.js``` ```host``` (linha 11) com o link do kanboard: ```localhost:80```

Rodar ```gulp watch``` na pasta ```Greenwing```

Agora basta modificar os arquivos scss na pasta ```Sass```

## Testes automatizados
Antes de rodar os testes, se certificar que não existem dados pré-existentes no banco de dados
Os comandos devem ser executados no container de desenvolvimento
### Testes unitários
- SQLite
```console 
foo@bar:~$ ./vendor/bin/phpunit -c tests/units.sqlite.xml
```
- MySQL
```console 
foo@bar:~$ ./vendor/bin/phpunit -c tests/units.mysql.xml
```
### Testes de integração
- SQLite
```console 
foo@bar:~$ ./vendor/bin/phpunit -c tests/integration.sqlite.xml
```
- MySQL
```console 
foo@bar:~$ ./vendor/bin/phpunit -c tests/integration.mysql.xml
```
### Integração contínua com Actions
Os testes automatizados serão executados em cada ```Pull Request```

### API
- Kanboard usa o protocolo Json-RPC para interagir com programas externos.
- JSON-RPC é um protocolo de chamada de procedimento remoto codificado em JSON. Quase a mesma coisa que XML-RPC, mas com o formato JSON.
- É utilizado a versão 2 do protocolo. Você deve chamar a API com uma solicitação ```POST HTTP```.
- [Documentação](https://docs.kanboard.org/en/latest/api/index.html)

## Créditos
- Criador: Frédéric Guillot
- Port: Felipe Felizardo Gonçalves
- [Contribuidores](https://github.com/kanboard/kanboard/graphs/contributors)
- [Repo](https://github.com/kanboard/kanboard)
- Licença [MIT License](https://github.com/kanboard/kanboard/blob/master/LICENSE)
