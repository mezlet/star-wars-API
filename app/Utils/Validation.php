<?php
namespace App\Utils;
use Laravel\Lumen\Routing\Controller as BaseController;

class Validation extends BaseController {
    public function validateComment($data){
        $this->validate($data,['comment' => 'required|string|max:500']);
        $this->validate($data,['movie_id' => 'required|numeric']);

    }
}
