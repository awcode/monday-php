<?php
namespace Awcode\MondayPHP;

use Awcode\MondayPHP\Models\Query;
use Awcode\MondayPHP\Models\Board;
use Awcode\MondayPHP\Models\Item;

class MondayPHP
{

    public function __construct($token=''){
        if($token){
            $this->access_token = $token;
        }
    }

    
    public function boards($id=null){
        $boards = new Board;
        $boards = $boards->findBoards($id);

        return $boards;
    }
    
    public function createBoard($board_name, $board_kind='public'){
        $board = new Board;
        return $board->create($board_name, $board_kind);
    }

}
