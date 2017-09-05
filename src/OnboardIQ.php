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
    const API_URL = 'https://www.onboardiq.com/api';
    const API_VERSION = 'v2';
    const API_URI = 'applicants';

    public $token = '';
    public $fullApiUrl = '';
    public $guzzleClient;


    public function __construct($token){
        $this->token = $token;
        $this->fullApiUrl = self::API_URL.'/'.self::API_VERSION.'/'.self::API_URI;
        $this->guzzleClient = new Client();
    }

    public function load($url='',$method='GET',$opt=[]){
        $res = $this->guzzleClient->request($method, $this->getFullUrl($url), $opt);
        return $res->getStatusCode() == 200?json_decode($res->getBody()):[];
    }

    public function getFullUrl($uri=''){
        $url = $this->fullApiUrl;
        $url .= $uri?'/'.$uri:'';
        $url .= '?api_token='.$this->token;
        return $url;
    }

    public function all(){
        return $this->load();
    }

    public function create($attributes){
        return $this->load('POST',$attributes);
    }

    public function update($id,$attributes){
        return $this->load($id,'PUT',$attributes);
    }

    public function get($id){
        return $this->load($id);
    }

    public function delete($id){
        return $this->load($id,'DELETE');
    }


}