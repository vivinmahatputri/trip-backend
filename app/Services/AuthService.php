<?php
/**
 * Created by PhpStorm.
 * User: eggy
 * Date: 20/09/18
 * Time: 18:38
 */

namespace App\Services;

use GuzzleHttp\Client;

class AuthService
{
    /**
     * @author Eggy Endeska <eggy.endeska@gmail.com>
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check()
    {
        $accessToken = request()->bearerToken();
        if($accessToken != null) {
            $client = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ];

            $response = $client->request('GET', route('auth.me'), [
                'headers' => $headers
            ]);

            if($response->getStatusCode() == 200){
                return true;
            }
            return false;
        }
        return false;
    }
}