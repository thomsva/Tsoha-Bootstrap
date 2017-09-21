<?php

class Wine extends BaseModel{

    public $id, $name, $region, $winetext, $type, $reviewstars, $reviewcount;

    public function _construct($attributes){
        parent::_construct($attributes);
    }

    public static function all(){
        $query=DB::connection()->prepare(
            'SELECT id,name,region,winetext,type,reviewstars,reviewcount 
            FROM Wine
            LEFT JOIN (SELECT wineid,AVG (stars) AS reviewstars, COUNT (id) AS reviewcount FROM Review GROUP BY wineid) AS r
            ON Wine.id=r.wineid;');
        $query->execute();
        $rows=$query->fetchAll();
        $wines=array();

        foreach($rows as $row){

            $wines[]=new Wine(array(
                'id'=>$row['id'],
                'name'=>$row['name'],
                'region'=>$row['region'],
                'winetext'=>$row['winetext'],
                'type'=>$row['type'],
                'reviewstars'=>$row['reviewstars'],
                'reviewcount'=>$row['reviewcount']

            ));
        }
        return $wines;
    }

    public static function find($id){
        $query=DB::connection()->prepare('SELECT * FROM Wine WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row=$query->fetch();

        if($row){
            $wine=new Wine(array(
                'id'=>$row['id'],
                'name'=>$row['name'],
                'region'=>$row['region'],
                'winetext'=>$row['winetext'],
                'type'=>$row['type']
            ));
            return $wine;
        }
        return null;

        
    }

    public function starstring(){
        $x=0;
        for ($i = 0; $i < $this->stars; $i++) {
            $x=$x+1;
        } 
        return $x;
    }

    public function save(){
        
        $query = DB::connection()->prepare('
            INSERT INTO Wine (name, region, winetext, type) 
            VALUES (:name, :region, :winetext, :type) RETURNING id');
        $query->execute(array(
            'name' => $this->name, 
            'region' => $this->region, 
            'winetext' => $this->winetext, 
            'type' => $this->type));
        $row = $query->fetch();
        $this->id = $row['id'];
      }


  }