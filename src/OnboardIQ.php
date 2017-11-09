<?php
namespace Myorb\OnboardIQ;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04.09.17
 * Time: 18:18
 */
class OnboardIQ
{
    const API_URL = 'https://api.fountain.com';
    const API_VERSION = 'v2';
    const API_URI = 'applicants';

    public $token = '';
    public $fullApiUrl = '';
    public $guzzleClient;


    public function __construct($token){
        $this->token = $token;
        $this->fullApiUrl = self::API_URL.'/'.self::API_VERSION.'/'.self::API_URI;
        $this->guzzleClient = new Client([
            'base_uri' => $this->fullApiUrl,
            'timeout'  => 2.0,
        ]);
    }

    public function load($uri='',$method='GET',$opt=[]){
        $request = $this->guzzleClient->createRequest($method,$this->fullApiUrl.'/'.$uri, $opt);
        $response = $this->guzzleClient->send($request);
        return $response->json();
    }

    public function all(){
        return $this->load('','GET',['query' => ['api_token'=>$this->token]]);
    }

    public function create(array $attributes){
        return $this->load('','POST',['body' => json_encode(array_merge($attributes,['api_token'=>$this->token,]))]);
    }

    public function update($id, $attributes){
        return $this->load($id,'PUT',['body' => json_encode(array_merge($attributes,['api_token'=>$this->token,]))]);
    }

    public function get($id){
        return $this->load($id,'GET',['query' => ['api_token'=>$this->token]]);
    }

    public function delete($id){
        return $this->load($id,'DELETE',['body' => json_encode(['api_token'=>$this->token])]);
    }


}
