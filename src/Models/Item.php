<?php
namespace Awcode\MondayPHP\Models;

class Item extends Query
{

    protected $scope = 'items';
    protected $fields = ['id','name','group', 'column_values'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
        'group' => 'group{id,title}',
        'column_values' => 'column_values{id,title,text,type}'
    ];

    protected $id;
    protected $board_id;
    
    public function __construct($id=null, $board_id=null){
        
        if(is_object($id)){
            $this->setIds($id->id);
            $this->data = $id;
        }elseif($id){
            $this->setIds($id);
            $this->id = $id;
        }
        if($board_id){$this->board_id = $board_id;}
    }
    
    
    public function getName(){
        return $this->data->name;
    }
    
    public function getId(){
        return $this->data->id;
    }
    
    public function getGroup(){
        return $this->data->group;
    }
    
    public function create($board_id, $item_name, $group_id='')
    {
        $this->board_id = $board_id;
        $this->scope = 'create_item';
        $args = '(board_id:'.(int)$board_id.', item_name:"'.$item_name.'"';
        if($group_id){$args.= ', group_id:"'.$group_id.'"';}
        $args .= ')';
        
        $data = $this->request('mutation', $args);
        return new Item($data->create_item, $board_id);
    }
    
    public function setColumn($column_id, $value){
        
        $this->scope = 'change_simple_column_value';
        $args = '(board_id:'.(int)$this->board_id.', item_id:'.$this->getId().',column_id:"'.$column_id.'",value:"'.$value.'")';
        
        $data = $this->request('mutation', $args);
        
        return $this;
    
    }
    
    public function createUpdate($body){
        $update = new Update;
        
        return $update->create($this->getId(), $body);
        
    }
    
    
    
}
