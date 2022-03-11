<?php
namespace Awcode\MondayPHP\Models;

class Board extends Query
{

    protected $scope = 'boards';
    protected $fields = ['id','name', 'description','owner', 'items'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
        'items' => 'items{name,id}',
        'description' => 'description',
        'owner' => 'owner{id,name}'
    ];

    public function __construct($id=null){
        if(is_object($id)){
            $this->setIds($id->id);
            $this->data = $id;
        }elseif($id){
            $this->setIds($id);
        }
    }
    
    public function findBoards($ids){
        $this->setIds($ids);
        
        $boards = $this->request();
        $arr = [];
        foreach($boards->boards as $board){
            $arr[] = new Board($board);
        }
        $this->data = $arr;
        //print_r($arr);die();
        return $this;
    }


    public function getName(){
        return $this->data->name;
    }
    
    public function getId(){
        return $this->data->id;
    }
    
    public function items(){
        
    
        $data = $this->request();
        
        $arr = [];
        foreach($this->data->items as $item){
            $arr[] = new Item($item);
        }

        
        return $arr;
    }
}
