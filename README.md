<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Teste Técnico - Desenvolvedor(a) Júnior · Laravel + Blade

## Como instalar e rodar o projeto

Clone o repositório com:
```bash
git clone https://github.com/marcodoninijr/teste-root-code.git
```

Acesse a pasta do projeto.

Instale as dependências do PHP com: 

```bash
composer install
```

Configure os arquivos de ambiente com:
```bash
cp .env.example .env
```
e
```bash
php artisan key:generate
```

Crie a base de dados SQLite e execute as migrations com:
```bash
touch database/database.sqlite
```
e
```bash
php artisan migrate
```

Inicie o servidor local com:
```bash
php artisan serve
```

Acesse o navegador em: http://localhost:8000/cotacoes/nova


## Como rodar os testes

Para executar os testes unitários (PHPUnit) que validam todas as regras de negócio:
```bash
php artisan test
```


## Decisões 

No arquivo resources\views\layouts\app.blade.php está definido o layout da página com bootstrap via CDN pra ficar mais organizado.

No arquivo resources\views\cotacoes\create.blade.php está a view do formulário, com os campos exigidos, rotas nomeadas e captura de erros.

No arquivo routes\web.php ficam as rotas da aplicação. 

No arquivo app\Http\Controllers\CotacaoController.php está o método create que chama a view do formulário. Também está a função store que valida os dados no formulário, chama o service para fazer os cálculos matemáticos, junta os dados validados com o cálculo em um array, guarda tudo na base de dados e redireciona para os detalhes da cotação. Também está a função show, que procura a cotação pelo ID e mostra os detalhes da cotação.

No arquivo app\Http\Requests\CotacaoRequest.php estão as regras do formulário, para garantir nenhum erro (como data impossível), a formatação dos dados inseridos e a tradução dos erros para português.

No arquivo database\migrations\2026_10_27_231609_create_cotacaos_table.php, criamos as tabelas no banco de dados, através do comando "php artisan migrate".

No arquivo app\Models\Cotacao.php está o model que permite gravar dados em todas as colunas de uma só vez.

No arquivo app\Services\CotacaoService.php está a lógica do cálculo dos dias cobrados através da manipulação das datas. Também está a devolução dos dados que precisam ser guardados no database.

No arquivo resources\views\cotacoes\show.blade.php há o HTML que mostra o resultado das cotações como uma tabela financeira.

No arquivo tests\Unit\CotacaoServiceTest.php temos os testes unitários para garantir que o comportamento do projeto está adequado.


## Resoluções de dúvidas

No problema do aniversário durante a viagem, a biblioteca Carbon já extrai a diferença de anos inteiros exclusivamente entre a data_nascimento e a data_inicio. Isso garante que a idade fique "congelada" e que o multiplicador cobrado seja o correto.

O Carbon devolvia a idade do viajante com várias casas decimais. No primeiro momento a idade era número gigante. O prolema foi resolvido com um simples (int) antes da variável convertendo o resultado para números inteiros.

No formulário das informações do viajante, adicionei uma caixa de seleção indicando se o viajante pagaria a cobertura de bagagem. Como os formulários HTML não enviam dados de checkboxes desmarcadas, foi necessário usar isset() no Service para evitar erros de índice indefinido e aplicar corretamente o acréscimo somente quando a opção fosse marcada.

