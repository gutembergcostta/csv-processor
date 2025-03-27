## Setup do projeto CSV Processor

Este projeto tem como objetivo receber um arquivo .csv de produtos com (código, nome, preço) e converter para Json já informando qual produto está com valor negativo.

Na montagem da tela existes botões para copiar o Json da linha do produto selecionado caso este tenha um número par em seu código, assim como conta com um botão no rodapé da página para que seeja possível copiar os dados dos produtos das linhas que forma selecionadas através do check.

## Passo a passo para instalação

Em seu diretório de trabalho ou na pasta que desejar abra um prompt e clone o repositório com o seguinte comando:

> Necessário que o git esteja instalado na máquina (git --version) para checar

```sh
git clone https://github.com/gutembergcostta/csv-processor.git
```

Após isso entre na pasta do repositório:

```sh
cd csv-processor
```

Para a execução da aplicação proponho duas opções.
**Basta realizar uma para testar o projeto!**

### 1 - A primeira - Execução do servidor PHP usando o servidor embutido

> Necessário que tenha o PHP em sua máquina (php --version) para checar

```sh
php -S localhost:8080 -t public
```

Ao executar este comando no seu prompt a aplicação deve estar disponível no link [http://localhost:8080](http://localhost:8080)

Ou você pode usar o Docker para subir um container da aplicação

### 2 - A segunda - Execução utilizando Docker

Dentro da pasta do projeto execute o seguinte comando em seu Terminal Ubuntu ou Terminal WSL

> Necessário que tenha o Docker esteja instalado em sua máquina (docker --version)

```sh
docker compose up -d --build
```

Se tudo correr bem a aplicação já deve estar disponível no link [http://localhost:8989](http://localhost:8989)

## Para os testes

Dentro do projeto você encontrará uma pasta com a descrição `planilhas_para_teste`, nela é possível encontrar arquivos com diferentes formatações e excessões para que possam ser usados durante as validações.

### Informações adicionais

Para este projeto utilizei uma APIController para gerenciar as chamadas onde nesta faz a montagem do Service desejado(no caso o de CSV).

O Service tem uma implementação de uma Interface para futuras adaptações que venham a surgir, como por exemplo a importação de um arquivo XML por exemplo.

A parte conveniente a produto, foi separada do Service para melhor organizar as responsabilidades das classes e facilitar a manutabilidade.

Foi criado também a parte de validação separada do service, onde esta tem uma validação específica para o CsvService que herda de uma FileValidator, onde esta útlima pode ser estanciada diretamente ou ser extendida por outra classe que venha a surgir.

Sem mais.

Att. Gutemberg Costa
