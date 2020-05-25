# Mini redis
Desafio Redis - Implementar um serviço que suporte um subconjunto de comandos do Redis

Requisitos:
 - Php > 7
 - Git
 - Composer
 - Banco Redis >= 3.2 (preferencialmente)

Para executar a aplicação, você precisa:
 - Clonar o repositório git@github.com:Renandiasmello/mini-redis.git
 - Fazer uma cópia do arquivo .env.example renomeando para .env e colocando suas credenciais do banco Redis, caso seja diferente do padrão
 - Criar a chave do .env rodando: php artisan key:generate
 - Rodar seu Redis Server
 - Inicializar a aplicação na porta 8080 digite no terminal(em seu diretório da aplicação): php artisan serve --host=127.0.0.1 --port=8080
 - Ir a url principal http://127.0.0.1:8080/api, 
 - Exemplo de aplicação do comando SET: http://127.0.0.1:8080/api?cmd=SET mykey cool-value
 - Exemplo de aplicação do comando GET: http://127.0.0.1:8080/api?cmd=GET mykey (Retornando "cool-value")
 - Utilizado e testado através da url do brownser

Aplicado os comandos solicitados:
 1. SET key value
 2. SET key value EX seconds (need not implement other SET options)
 3. GET key
 4. DEL key
 5. DBSIZE
 6. INCR key
 7. ZADD key score member
 8. ZCARD key
 9. ZRANK key member
 10. ZRANGE key start stop