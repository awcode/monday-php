<?php
namespace Awcode\MondayPHP;

use Awcode\MondayPHP\Models\Query;
use Awcode\MondayPHP\Models\Board;

class MondayPHP
{
    
    private $access_token;
    private $api_endpoint = 'https://api.monday.com/v2/';
    protected $query;
    
    
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
    
    public function request(){
        $this->authorise();
        
        $headers = [
            'Content-Type: application/json',
            'User-Agent: AwcodeMondayPHP',
            'Authorization: ' . $this->access_token
        ];

        
        $data = @file_get_contents($this->api_endpoint, false, stream_context_create([
          'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $this->query->json()]),
          ]
        ]));
        $responseContent = json_decode($data);

        //echo json_encode($responseContent);die();
        return $responseContent->data;
    }
    
    public function getBoards($id=null){
        $this->query = new Board($id);
        //$query->setLimit(99);
        //$query->addField('description');
        
        return $this;
    }
    public function getItems(){
        $this->query->addField('items');
    
        $data = $this->request();
        print_r($data->boards[0]->items);die();
        return $data->boards[0]->items;
    }
    
    public function get(){
        return $this->request();
    }
    
   
}
