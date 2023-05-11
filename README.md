
# Case de api

Uma breve descrição sobre o que esse projeto faz.


## Funcionalidades

- Sistema de gerenciamento de rotas
- CLI 
- Migrations
- Modal
- Controller
- Cadastro de usuários
- Transferência de pagamento


## Documentação da API

#### Rota de cadastro de usuário


As respostas vem com status e message.
```
  Code do retorno
  status 200 => OK, processo foi concluído com sucesso
  status 205 => Ok, processo principal foi concluído com sucesso mas houve um problema externo
  status 400 => Houve um erro
```

```http
  POST /usuario
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `nomeCompleto` | `string` | **Obrigatório**. |
| `email`        | `string` | **Obrigatório e Único**.  |
| `cpf`          | `string` | **Obrigatório e Único**. |
| `cnpj`          | `string` | **Não Obrigatório**. |
| `senha`          | `string` | **Obrigatório**. |
| `saldo`          | `decimal` | **valor padrão para teste 200**. |

#### Faz transferência bancária

```http
  PUT /transferencia
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `payee`      | `string` | **Obrigatório, id do Recebedor**. |
| `payer`      | `string` | **Obrigatório, id do Pagador**. |
| `value`      | `string` | **Obrigatório, formato de exemplo: 100.00**. |



## Documentação


O projeto utiliza de uma arquitetura de Model-Controller e uma

estrutura de modular, utilizando php puro sem auxílio de frameworks.

Para ver a listagem dos comandos, use terminal.

**php artisan --help ou php artisan componente help**.

### Rotas

As rotas são registradas dentro do método loadRoutes da classe Web, dentro do src/Routers/Web.php

As rotas são registradas utilizando a classe Route.

Exemplos de registros de rotas:

```php
Route::post('domain/path',[Controller::class, 'método'])
Route::get('domain/path/{id}',[Controller::class, 'método'])
Route::delete('domain/path',[Controller::class, 'método'])
Route::put('domain/path',[Controller::class, 'método'])
```

No terminal, use:

 **php artisan route list**
 
Veja todas as rotas e os seus controller registrados na aplicação.

No verbo Get, recebe um array associativo no terceiro parâmetro.

### Controller

Para criar uma classe de controller, use o comando no terminal:

**php artisan controller api <Nome da classe de controller>**

No diretório src/Controller será criado uma classe de controller.

As funções recebem request, response e um array no caso de opção do path.
Exemplo:

   Rota registrada: localhost/usuario/{id}
  
   Rota da requisição: localhost/usuario/1

função recebe terceiro parâmetro com array [id=>1];
   

### Migrations

Para criar uma migration use o comando:

**php artisan migrations create <nome da migrations>**

Vai criar um arquivo no src/Migrations com método up, nele
vai receber um variável ITable, na qual será usada para criar a tabela e deverá ser passada como retorna da função.

#### ITable

métodos:
- string
- decimal
- id

opções:
- unsigned
-  notNull
- unique
- default

Exemplo de uso: **$table->string('column')->default('lojista')**;

## Modal


Para criar um modal use o comando:

**php artisan modal create <nome>**

Vai criar um arquivo no src/Modal;

métodos
```
    select(array $colunas)
    insert(array $colunasValores): Exemplo ['nome' => 'fernando']
    where($column, $condição,string $valor, $condiçãoSegundaria): A condição segundária serve quando for fazer união de wheres
```

## Teste

diretório **test** fica os arquivos para serem executados com phpunit.

No terminal use **php artisan test start**.

    
## Rodando localmente

Clone o projeto

```bash
  git clone https://github.com/norionXt/case.git api
```

Entre no diretório do projeto

```bash
  cd api
```

Instale as dependências

```bash
  composer install
```

Inicie o servidor

```bash
  docker-compose -f "docker-compose.yml" up -d --build 
```

Execute script bash para subir o banco de dados e executa cron para executar atividades que não foram concluídas.

Exemplo de servições de terceiros que ficaram indisponível.

```bash
  chmod 777 config.sh
  ./config.sh 
```
