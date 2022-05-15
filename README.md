# Como rodar o projeto:
```
$ composer install
```
```
$ cp .env.example .env
```
Existe um arquivo chamado vhost.example, caso queira configurar no nginx ou apache. É possivel também dar start no servidor com o comando:
```
$ php artisan serve
```
Obs: Nesse caso é preciso alterar a varivael de ambiente no front-end.

Para o envio de email funcionar é preciso colocar as credenciais de um servidor SMTP no arquivo .env (Sugiro mailtrap).