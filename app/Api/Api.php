<?php

namespace App\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Api {

    function __construct() {
        $this->URL_SERVER_API = env('URL_SERVER_API');
    }

    public function sendRequest($method, $url, $data = []){
        $client = new Client();
        $response = $client->request($method, $this->URL_SERVER_API.$url, [
            'headers' => [
                'content-type' => 'application/json',
                'Authorization' => Cache::get('access_token','')
            ],
            'body' => json_encode($data)
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function uploadImage($method, $url, $data = []){
        $client = new Client();
        $response = $client->request($method, 'http://picture.rbcenter.tk/'.$url, [
            'headers' => [
                'content-type' => 'application/json',
                'Authorization' => Cache::get('image_access_token','')
            ],
            'body' => json_encode($data)
        ]);
        return json_decode($response->getBody()->getContents());
    }


}