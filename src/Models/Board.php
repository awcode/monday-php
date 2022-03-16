<?php
namespace Awcode\MondayPHP\Models;

class Board extends Query
{

    protected $scope = 'boards';
    protected $fields = ['id','name', 'description','owner', 'items', 'groups'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
        'items' => 'items{name,id}',
        'description' => 'description',
        'owner' => 'owner{id,name}',
        'groups' => 'groups{id,title}'
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
        
        return $this;
    }
    
    public function create($board_name, $board_kind){
        $this->scope = 'create_board';
        $data = $this->request('mutation', '(board_name:"'.$board_name.'", board_kind:'.$board_kind.')');
        return new Board($data->create_board);
    }
    
     public function createItem($item_name, $group_id=''){
        $item = new Item;
        
        return $item->create($this->ids, $item_name, $group_id);
        
    }
    
    public function createGroup($group_name, $group_id=''){
        $group = new Group;
        
        return $group->create($this->ids, $group_name, $group_id);
        
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
            $arr[] = new Item($item, $this->getId());
        }
       
        return $arr;
    }
}
