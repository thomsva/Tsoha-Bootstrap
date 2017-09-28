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
            LEFT JOIN (SELECT wineid, COALESCE(AVG(stars),0) AS reviewstars, 
                COALESCE(COUNT (id),0) AS reviewcount FROM Review GROUP BY wineid) AS r
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
        $query=DB::connection()->prepare(
            'SELECT id,name,region,winetext,type,reviewstars,reviewcount 
            FROM Wine
            LEFT JOIN (SELECT wineid,AVG (stars) AS reviewstars, COUNT (id) AS reviewcount FROM Review GROUP BY wineid) AS r
            ON Wine.id=r.wineid
            WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row=$query->fetch();

        if($row){
            $wine=new Wine(array(
                'id'=>$row['id'],
                'name'=>$row['name'],
                'region'=>$row['region'],
                'winetext'=>$row['winetext'],
                'type'=>$row['type'],
                'reviewstars'=>$row['reviewstars'],
                'reviewcount'=>$row['reviewcount']

            ));
            return $wine;
        }
        return null;

        
    }

    public function starstring(){
        //muuttaa viinin arvostelun tähdiksi, esim. 3=***. 
        $x=" ";
        //Kint::dump($this->reviewstars);
        for ($i = 0; $i < $this->reviewstars; $i++) {
            $x=$x."*";
        } 
        return $x;
    }

    public function save(){
        //tallentaa Wine-olion tietokantaan uutena rivinä
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

    public function update(){
        //tallentaa Wine-olion muutokset tietokantaan 
        $query = DB::connection()->prepare('
            UPDATE Wine
            SET name=:name, 
            region=:region, 
            winetext=:winetext,
            type=:type
            WHERE id=:id');
        $query->execute(array(
            'id' => $this->id,
            'name' => $this->name, 
            'region' => $this->region, 
            'winetext' => $this->winetext, 
            'type' => $this->type));
    }

    

    public function destroy(){
        $query = DB::connection()->prepare('
        DELETE FROM Wine
        WHERE id=:id');
    $query->execute(array(
        'id' => $this->id));        
    }




  }