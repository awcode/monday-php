<?php
namespace Awcode\MondayPHP\Models;

class Item extends Query
{

    protected $scope = 'items';
    protected $fields = ['id','name'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
    ];

    protected $id;
    
    
    public function __construct($id){
        
        if(is_object($id)){
            $this->setIds($id->id);
            $this->data = $id;
        }elseif($id){
            $this->setIds($id);
            $this->id = $id;
        }
    }
    
    
    public function getName(){
        return $this->data->name;
    }
    
    public function getId(){
        return $this->data->id;
    }
    
    
}
