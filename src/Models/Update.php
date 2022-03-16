<?php
namespace Awcode\MondayPHP\Models;

class Update extends Query
{

    protected $scope = 'updates';
    protected $fields = ['id','body'];
    protected $available_fields = [
        'id' => 'id',
        'body' => 'body'
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
    
    
    
    public function create($item_id, $body)
    {
    

        
        $this->scope = 'create_update';
        $args = '(item_id:'.$item_id.',body:"'.$body.'")';
        
        $data = $this->request('mutation', $args);
        
        return new Update($data->create_update);
    }
    
}
