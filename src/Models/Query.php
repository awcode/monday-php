<?php
namespace Awcode\MondayPHP\Models;

class Query
{
    
    private $access_token;
    private $api_endpoint = 'https://api.monday.com/v2/';
    
    protected $limit = 10;
    protected $page = 1;
    protected $scope = '';
    protected $ids = '';
    protected $fields = [];
    protected $available_fields = [];
    protected $query;
    public $data;
    
    public function __construct($id=null){
        if($id){
            $this->setIds($id);
        }
    }
    public function setScope($scope){
        $this->scope = $scope;
    }
    
    public function setIds($ids){
        $this->ids = $ids;
    }
    
    public function setLimit($limit){
        $this->limit = $limit;
    }
    
    public function setPage($page){
        $this->page = $page;
    }
    
    public function setFields($fields){
        $this->fields = $fields;
    }
    
    protected function authorise(){
        if(!$this->access_token){
            $this->access_token = (function_exists('config') && config('monday.access_token')) ? config('monday.access_token') : env('MONDAY_TOKEN');
        }
        if(!$this->access_token){
            die('No Monday.com access token');
        }
    }
    
    public function request($mode = 'query', $args=null){
        $this->authorise();
        if($args == null){$args = $this->searchArgs();}
        $headers = [
            'Content-Type: application/json',
            'User-Agent: AwcodeMondayPHP',
            'Authorization: ' . $this->access_token
        ];
        //echo $this->json($mode, $args); die();
        $data = @file_get_contents($this->api_endpoint, false, stream_context_create([
          'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $this->json($mode, $args)]),
          ]
        ]));
        $responseContent = json_decode($data);
        if(!isset($responseContent->data)){echo $this->json($mode, $args); print_r($responseContent);die();}
        return $responseContent->data;
    }
    
    public function get(){
        return $this->data;
    }
    
    public function first(){
        return $this->data[0];
    }
    
    public function getData(){
        return $this->data;
    }
    
    public function addField($field){
        if(isset($this->available_fields[$field]) && ! in_array($field, $this->fields)){
            $this->fields[] = $field;
        }
        return $this;
    }
    
    public function searchArgs(){
        $args = '(limit:'.$this->limit.', page:'.$this->page;
        if($this->ids){
            $args .= ', ids: '.(is_array($this->ids) ? implode(' ', $this->ids) : $this->ids) ;
        }
        $args .=' )';
        return $args;
    }
    public function json($mode, $args){
        
        
        $fields = '';
        foreach($this->fields as $field){
            $fields .= $this->available_fields[$field].' ';
        }
        if($fields){$fields = '{'.$fields.'}';}
        
        $json = $mode.'{ '.$this->scope.' '.$args.' '.$fields.'  }';
        
        return $json;
    
    }
    
    
}
