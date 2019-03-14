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
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFhYWZlYWUxMzZmZWI0N2M0MWJhYzU5ODQ4MjFkOTRjYTJkZjc5MTc3ZWM0NGRmYTdjN2E3MzQzZDVjMGQzNTE5YmMxMjE1NmM2MmQyMGZjIn0.eyJhdWQiOiIyIiwianRpIjoiMWFhZmVhZTEzNmZlYjQ3YzQxYmFjNTk4NDgyMWQ5NGNhMmRmNzkxNzdlYzQ0ZGZhN2M3YTczNDNkNWMwZDM1MTliYzEyMTU2YzYyZDIwZmMiLCJpYXQiOjE1NTIzOTUyNjIsIm5iZiI6MTU1MjM5NTI2MiwiZXhwIjoxNTUzNjkxMjYyLCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.n1AA1h-kt6LyvB2FIlU4R7tErtshs3rYzjUgw4fLBa-K4rlwcx8AvLov8kILmZJj7ARCsmpspWVVh17Fc6p0zCuLcMyk6ifrwPz1FMHdXC8rgjnZo4Vwlk64_93jcX2a1YxxV2RmzUkvLRttPQzINxCMYQtiGKzRwOzIE1-HbcaORu9v6y8ONNhNf5RbIP62Lbqf5fqgqNB7meckmcrdHDbdSCW72sfUbWDzgt5FmyBlNVRPS0etg9tzsAZgpqYIVh-VkpUWlN3gtGjIu25raGgqVec6LK0ulumRm2MDmGpBv3sRinrC929JBsLCZkAmim7JWVwitV2wZf0Bd05Eda13pt0DkhmjjzOzwU6q2Z-M4-0JniWgt95I6NhYqcrT47KXtFBc0zEbF0wkvMZumloue_qFLB0TaTS6SJxyUHFnw7Sr8vRye93Kq5L6og9100k5YiF3gE2chd6FvM2LAkYwuo2IaKJN-b1NJUM8dyxPTDVB3iXLdMFuw7AI3mlbW-SxJhkV0YhLKGCx6mQL8-uchTYCCX8A_giyD2NicnBHNbg0Qda24K2WPxNmjKG6sC-ZVkgpTU0hwQ5YfuLH9U9VMt-4bLgA79-bWyLolLWGj278xQ5yt3rXmtYU7roBgYyuIaV90rCz1Ivau0pKBLmIyCC0tH39QjWoH-4SEkY'
            ],
            'body' => json_encode($data)
        ]);
        return json_decode($response->getBody()->getContents());
    }

}