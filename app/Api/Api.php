<?php

namespace App\Api;

use GuzzleHttp\Client;

class Api {

    function __construct() {
        $this->URL_SERVER_API = env('URL_SERVER_API');
    }

    public function sendRequest($method, $url, $data = []){
        $client = new Client();
        $response = $client->request($method, $this->URL_SERVER_API.$url, [
            'headers' => [
                'content-type' => 'application/json',
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJmYTgzYzNkMDYzZDFiNmQ5ZGY0Zjc2NzhhNmZjZGRhMDFmMjE1NmE2OTZjNmQ4NWYyZTA0YmFjZWFmMmVlZmRmZWZhOGRmOGI4NmYxYjI2In0.eyJhdWQiOiI1IiwianRpIjoiYmZhODNjM2QwNjNkMWI2ZDlkZjRmNzY3OGE2ZmNkZGEwMWYyMTU2YTY5NmM2ZDg1ZjJlMDRiYWNlYWYyZWVmZGZlZmE4ZGY4Yjg2ZjFiMjYiLCJpYXQiOjE1NTE5NTM3MjUsIm5iZiI6MTU1MTk1MzcyNSwiZXhwIjoxNTUzMjQ5NzI1LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.gr5FFonGUYCXMaL0gBqsspWM52c3hz2eodo0dmjBlPTjXApe986OyICIGWowuevEK2svp8KvUuYHg2IXkcSDeTLt7VVS5jJ-LZP6tqyG7AMeMThvl-3xJ-uXPXZ31y8psE-OF2foybfjH1c-7A5BSNUp_RE0iHTiR8yUiXWGzglcCvbNIthAprU5mD5w07SWU6JEfnHEy6W26f8R8xX9x-Fk1drTxTMoDjuYuNc9dpMmdrJZNwCeP6dsfS93SMDvkbPP-UieGIAemBo_h91gK6H0nNz9jRQA7KnKGeeBbTl3FqCZ1Ys2mbBcdLZZwqiNzMNzsQ0ecnbB_UonzLpPJ5wDd_BjUJ5zZWqb8_eMYJq5MmhEVPNZy_iWfUTkuNj4fqm2_2a0_eCW8Ty3Pk0aeu_8sHNmXx2Lgt-RQzRMDc0JuU3jFA7zczoURUMUKcpvPdqqQlx031foOsfP3ynEytkOQv8ot6uNNegB4JOch1WWHXAVI1lfwCyjt7JsA6rJfxTfAQOZC27TJCOJeAKfzX0NRPuEW9ZSb4lLMVmGH2Y9QZkCDN4hZ3_cwx9tNdEhYOyT4oDTEvF1HCPAOLaldj0BiYwqKVqfdeQHsGt15MEXuJ-I4BB-BQyh_Q176xL4UK0zUEW54zBTI3Uam9ruuN3FyjVs4UEDLYJMxlRmBSw'
            ],
            'body' => json_encode($data)
        ]);
        return json_decode($response->getBody()->getContents());
    }

}