# BeGaming

Este projeto tem como objetivo facilitar a gestão e o acompanhamentos do sistema de bagdes que a Before implantou.

## Como Contribuir?

É possível contribuir de várias formas ao projeto dentre elas são:

 - Desenvolver funcionalidades
 - Sugerir funcionalidades
 - Reportar erros
 - Corrigir erros
 - Aumentar a cobertura de testes
 - Incrementar documentação
 
## Como rodar o projeto local ? [Ubuntu]

A princípio, é preciso ter os seguintes softwares instalados:

- Docker
- Docker-Compose

Para começar a rodar o projeto, há os seguintes passos:

- Clonar o projeto do Git
- Rodar os seguintes comandos na pasta do projeto:

1) docker-compose up
2) docker exec begaming-app php artisan key:generate
3) docker exec begaming-app php artisan migrate
4) docker exec begaming-app composer dump-autoload
5) docker exec begaming-app php artisan db:seed
6) docker exec begaming-app php artisan storage:link

- PRONTO!
 
Por favor leia nosso [Código de Conduta] para detalhes do nosso código de conduta.

[Código de Conduta]: https://github.com/robertoperes/begaming/blob/master/CODE_OF_CONDUCT.md
