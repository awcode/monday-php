<?php
namespace Awcode\MondayPHP\Models;

class Board extends Query
{

    protected $scope = 'boards';
    protected $fields = ['id','name'];
    protected $available_fields = [
        'id' => 'id',
        'name' => 'name',
        'items' => 'items{name,id}',
        'description' => 'description'
    ];



    
    
}
