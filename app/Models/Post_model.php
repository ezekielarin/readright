<?php

namespace App\Models;

use CodeIgniter\Model;

class Post_model extends Model{

    protected $table = "posts";

    public function create_post($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }


    public function get_posts($id = null){
        
        if(!empty($id)){
            $builder = $this->db->table("posts")->where('id',$id);
        }else{
            $builder = $this->db->table("posts");
        }
        $query   = $builder->get();
        return $query;
    }



}