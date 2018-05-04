<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ClientSimulatorController extends Controller
{
    public function index($count)
    {
        $client = new Client(['timeout' => 20]);
        echo "Start generating {$count} requests </br>";

        for($index=1;$index<=$count;$index++) {
            $promises[$index] = $client->requestAsync('GET', url('request', ['index' => $index]))->then(
                function (Response $response){

                    return [
                        'success'    => 1,
                        'response' => $response
                    ];
                },
                function ($reason){
                    return [
                        'success'    => 0,
                        'reason'    =>$reason
                    ];
                }
            );
        }
        $result = collect(\GuzzleHttp\Promise\unwrap($promises));

        $result->each(function($item){
            echo ($item['success']?'Succeeded':'Failed').'</br>';
            print_r($item['response']->getBody()->__toString());
            echo '</br>';
        });

        echo "End generating {$count} requests </br>";
    }
}
