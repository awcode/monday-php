<?php
namespace Awcode\MondayPHP\Models;

class Item extends Query
{

    protected $scope = 'items';
    protected $fields = ['id','name','group'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
        'group' => 'group{id,title}'
    ];

    protected $id;
    
    
    public function __construct($id=null){
        
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
    
    public function getGroup(){
        return $this->data->group;
    }
    
    public function create($board_id, $item_name, $group_id='')
    {
    
        $this->scope = 'create_item';
        $args = '(board_id:'.(int)$board_id.', item_name:"'.$item_name.'"';
        if($group_id){$args.= ', group_id:"'.$group_id.'"';}
        $args .= ')';
        
        $data = $this->request('mutation', $args);
        return new Item($data->create_item);
    }
    
}
