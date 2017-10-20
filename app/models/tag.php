<?php

class Tag extends BaseModel{

    public $id, $tagtext;

    public function _construct($attributes){
        parent::_construct($attributes);
    }

    public static function all(){
        $query=DB::connection()->prepare(
            'SELECT * 
            FROM Tag
            ORDER BY id');
        $query->execute();
        $rows=$query->fetchAll();
        $tags=array();

        foreach($rows as $row){

            $tag=new Tag(array(
                'id'=>$row['id'],
                'tagtext'=>$row['tagtext'],             
                
            ));

            $tags[]=$tag;

        }
        return $tags;
    }

    public static function find($id){
        $query=DB::connection()->prepare(
            'SELECT * 
            FROM Tag
            WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row=$query->fetch();

        if($row){
            $tag=new Tag(array(
                'id'=>$row['id'],
                'tagtext'=>$row['tagtext']
            ));
            return $tag;
            
        }
        return null;        
    }
    



  }