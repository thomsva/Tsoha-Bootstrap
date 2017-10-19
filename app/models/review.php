<?php

class Review extends BaseModel{

    public $id, $userid, $wineid, $reviewtext, $stars, $tags, $username;

    public function _construct($attributes){
        parent::_construct($attributes);
    }

    public static function all($wineid){
        $query=DB::connection()->prepare(
            'SELECT Review.id, Review.usrid, Review.wineid, Review.reviewtext,
            Review.stars, Usr.name AS usrname
            FROM Review LEFT JOIN Usr
            ON Review.usrid=Usr.id
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
                'username'=>&row['usrname']
            ));
            $review->tags();
            $reviews[]=$review;
            kint::dump(review);
        }

        return $reviews;
    }

    public static function find($id){
        $query=DB::connection()->prepare(
            'SELECT Review.* , Usr.name AS username
            FROM Review
            LEFT JOIN Usr
            ON Review.userid=Usr.id
            WHERE Review.id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row=$query->fetch();

        if($row){
            $review=new Review(array(
                'id'=>$row['id'],
                'userid'=>$row['usrid'],
                'wineid'=>$row['wineid'],
                'reviewtext'=>$row['reviewtext'],
                'stars'=>$row['stars'],
                'username'=>&row['username']
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
            INSERT INTO Review (usrid, wineid, reviewtext, stars) 
            VALUES (:userid, :wineid, :reviewtext, :stars) RETURNING id');
        $query->execute(array(
            'userid' => $this->userid, 
            'wineid' => $this->wineid, 
            'reviewtext' => $this->reviewtext, 
            'stars' => $this->stars));
        $row = $query->fetch();
        $this->id = $row['id'];
        $this->savetags();
    }

    public function savetags(){
        //poistaa ensin mahdolliset vanhat tagit
        $query = DB::connection()->prepare('
            DELETE FROM Reviewtag
            WHERE reviewid=:id');
        $query->execute(array(
            'id' => $this->id));

        //lisätään tagit tietokantaan
        foreach($this->tags as $tag){
            $query = DB::connection()->prepare('
            INSERT INTO Reviewtag (reviewid, tagid) 
            VALUES (:reviewid, :tagid)');
            $query->execute(array(
                'reviewid' => $this->id, 
                'tagid' => $tag 
            ));
        }
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
            'id' => $this->id,
            'userid' => $this->userid,
            'wineid' => $this->wineid, 
            'reviewtext' => $this->reviewtext, 
            'stars' => $this->stars
        ));
        $this->savetags();
    }

    

    public function destroy(){
        $query = DB::connection()->prepare('
            DELETE FROM Review
            WHERE id=:id');
        $query->execute(array(
            'id' => $this->id));        
    }


  }