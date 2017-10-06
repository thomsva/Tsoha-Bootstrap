<?php

class Review extends BaseModel{

    public $id, $userid, $wineid, $reviewtext, $stars, $tags;

    public function _construct($attributes){
        parent::_construct($attributes);
    }

    public static function all($wineid){
        $query=DB::connection()->prepare(
            'SELECT * 
            FROM Review
            WHERE wineid=:wineid
            ORDER BY id');
        $query->execute(array(
            'wineid' => $wineid));
        $rows=$query->fetchAll();
        $reviews=array();

        foreach($rows as $row){
            
            

            $review=new Review(array(
                'id'=>$row['id'],
                'userid'=>$row['usrid'],
                'wineid'=>$row['wineid'],
                'reviewtext'=>$row['reviewtext'],
                'stars'=>$row['stars'],
                
                
            ));
            
            $review->tags();
            $reviews[]=$review;

        }
        return $reviews;
    }

    public static function find($id){
        $query=DB::connection()->prepare(
            'SELECT * 
            FROM Reviews
            WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row=$query->fetch();

        if($row){
            $review=new Review(array(
                'id'=>$row['id'],
                'userid'=>$row['usrid'],
                'wineid'=>$row['wineid'],
                'reviewtext'=>$row['reviewtext'],
                'stars'=>$row['stars']
            ));
            return $review;
        }
        return null;        
    }

    public function tags(){
        $query=DB::connection()->prepare(
            'SELECT * 
            FROM ReviewTag LEFT JOIN Tag
            ON ReviewTag.tagid=Tag.id
            WHERE Reviewtag.reviewid=:id');

        $query->execute(array('id' => $this->id)); 
        $rows=$query->fetchAll();
        $tags=array();

        foreach ($rows as $row){
            $tags[]=new Tag(array(
                'id'=>$row['id'],
                'tagtext'=>$row['tagtext']
            ));
        }
        $this->tags=$tags;
            
        return $this;
        
               
    }


    public function save(){
        //tallentaa Review-olion tietokantaan uutena rivinä
        $query = DB::connection()->prepare('
            INSERT INTO Review (userid, wineid, reviewtext, stars) 
            VALUES (:userid, :wineid, :reviewtext, :stars) RETURNING id');
        $query->execute(array(
            'usrid' => $this->userid, 
            'wineid' => $this->wineid, 
            'reviewtext' => $this->reviewtext, 
            'stars' => $this->stars));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update(){
        //tallentaa Review-olion muutokset tietokantaan 
        $query = DB::connection()->prepare('
            UPDATE Review
            SET usrid=:userid, 
            wineid=:wineid, 
            reviewtext=:reviewtext,
            stars=:stars
            WHERE id=:id');
        $query->execute(array(
            'usrid' => $this->userid,
            'wineid' => $this->wineid, 
            'region' => $this->region, 
            'reviewtext' => $this->reviewtext, 
            'stars' => $this->stars));
    }

    

    public function destroy(){
        $query = DB::connection()->prepare('
        DELETE FROM Review
        WHERE id=:id');
    $query->execute(array(
        'id' => $this->id));        
    }




  }