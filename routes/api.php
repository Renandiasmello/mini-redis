<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function(Request $request){
    
    if(isset($_GET['cmd']) && !empty($_GET['cmd'])):
        $arr = explode(' ', $_GET['cmd']);
        $arr = array_filter($arr, 'strlen');
        
        if(isset($arr[1])){
            if(!preg_match("(^[A-Za-z][A-Za-z0-9-_]{1,99}$)", $arr[1] ) ) {
                return 'Chave inválida';
            }
        }
         
        if(isset($arr[2])){
            if(!preg_match("(^[A-Za-z][A-Za-z0-9-_]{1,99}$)", $arr[2] ) ) {
                return 'Valor inválido';
            }
        }

        if(count($arr) < 1):
            return 'Argumentos insuficientes para requisição de dados.';
        endif;
        ## Reordenar os indices do array
        $arr = array_values($arr);

        switch(strtoupper($arr[0])) {
            case 'SET':
                if(count($arr) < 3):
                    return 'Argumentos insuficientes para gravar os dados (SET).';
                endif;
                Redis::set("{$arr[1]}", "$arr[2]");
                return 'OK: ' . Redis::get("{$arr[1]}");
            break;
            case 'GET':
                if(count($arr) < 2):
                    return 'Argumentos insuficientes para ler os dados (GET).';
                endif;
                return Redis::get("{$arr[1]}") ? Redis::get("{$arr[1]}") : 'Não há registros.' ;
            break;
            case 'DEL':
                if(count($arr) < 2):
                    return 'Argumentos insuficientes para excluir os dados (DEL).';
                endif;
                Redis::del("{$arr[1]}");
                return 'OK';
            break;
            case 'DBSIZE':
                return Redis::dbsize();
            break;
            case 'INCR':
                if(count($arr) < 2):
                    return 'Argumentos insuficientes para incrementar o número (INCR).';
                endif;
                $val = Redis::get("{$arr[1]}");
                if(!filter_var($val, FILTER_VALIDATE_INT)) { 
                    return 'A chave com o valor informado deve conter um número inteiro.';
                }
                return Redis::incr("{$arr[1]}");
            break;
            case 'ZADD':
                if(count($arr) < 4):
                    return 'Argumentos insuficientes para salvar os dados (ZADD).';
                endif;
                return Redis::zadd("{$arr[1]}", "{$arr[2]}", "{$arr[3]}");
            break;
            case 'ZCARD':
                if(count($arr) < 2):
                    return 'Argumentos insuficientes para buscar os dados (ZCARD).';
                endif;
                return Redis::zcard("{$arr[1]}");
            break;
            case 'ZRANK':
                if(count($arr) < 3):
                    return 'Argumentos insuficientes para retornar os dados (ZRANK).';
                endif;
                return Redis::zrank("{$arr[1]}", "{$arr[2]}") ? Redis::zrank("{$arr[1]}", "{$arr[2]}") : 'Não há registros.';
            break;
            case 'ZRANGE':
                if(count($arr) < 4):
                    return 'Argumentos insuficientes para salvar os dados (ZADD).';
                endif;
                return Redis::zrange("{$arr[1]}", "{$arr[2]}", "{$arr[3]}");
            break;
            default:
                return 'Comando inválido.';
            break;
        }
    else:
        return 'Dados inválidos para a requisição.';
    endif;
    
});