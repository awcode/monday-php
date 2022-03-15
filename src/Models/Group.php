<?php
namespace Awcode\MondayPHP\Models;

class Group extends Query
{

    protected $scope = 'groups';
    protected $fields = ['id','title'];
    protected $available_fields = [
        'id' => 'id',
        'title' => 'title'
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
    
    
    public function getTitle(){
        return $this->data->title;
    }
    
    public function getId(){
        return $this->data->id;
    }
    
    
    
    public function create($board_id, $group_name)
    {
    
        $this->scope = 'create_group';
        $args = '(board_id:'.(int)$board_id.', group_name:"'.$group_name.'")';
        
        $data = $this->request('mutation', $args);
        return new Group($data->create_group);
    }
    
}
