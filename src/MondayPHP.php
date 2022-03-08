<?php
namespace Awcode\MondayPHP;

use Awcode\MondayPHP\Helpers\ThaiAddress;
use Awcode\ThaiLaravel\Helpers\ThaiFormat;
use Awcode\ThaiLaravel\Helpers\ThaiPhone;
use Awcode\ThaiLaravel\Helpers\ThaiIdentityCard;

class MondayPHP
{
    
    private $access_token;
    private $api_endpoint = 'https://api.monday.com/v2/';
    
    
    public function __construct($token=''){
        if($token){
            $this->access_token = $token;
        }
    }
    
    protected function authorise(){
        if(!$this->access_token){
            $this->access_token = config('monday.access_token') ?? env('MONDAY_TOKEN');
        }
        if(!$this->access_token){
            die('No Monday.com access token');
        }
    }
    
    public function request($query){
        $this->authorise();
        
        $headers = [
            'Content-Type: application/json',
            'User-Agent: AwcodeMondayPHP',
            'Authorization: ' . $this->access_token
        ];

        $query = '{ boards (limit:1) {id name} }';
        $data = @file_get_contents($this->api_endpoint, false, stream_context_create([
          'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $query]),
          ]
        ]));
        $responseContent = json_decode($data, true);

        echo json_encode($responseContent);
        return $responseContent;
    }
}
