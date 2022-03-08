<?php
namespace Awcode\MondayPHP\Models;

class Query
{
    
    protected $limit = 10;
    protected $page = 1;
    protected $scope = '';
    protected $ids = '';
    protected $fields = [];
    protected $available_fields = [];
    
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
    
    public function addField($field){
        if(isset($this->available_fields[$field]) && ! in_array($field, $this->fields)){
            $this->fields[] = $field;
        }
    }
    
    public function json(){
        $args = '(limit:'.$this->limit.', page:'.$this->page;
        if($this->ids){
            $args .= ', ids: '.(is_array($this->ids) ? implode(' ', $this->ids) : $this->ids) ;
        }
        $args .=' )';
        
        $fields = '{';
        foreach($this->fields as $field){
            $fields .= $this->available_fields[$field].' ';
        }
        $fields .= '}';
        
        $json = '{ '.$this->scope.' '.$args.' '.$fields.'  }';
        
        return $json;
    
    }
}
