<?php

class User extends BaseModel{
    
    public $id, $email, $name, $admin, $password;

    public function _construct($attributes){
        parent::_construct($attributes);
    }

    public static function find($userid){
        $query = DB::connection()->prepare('SELECT * FROM usr WHERE id = :userid LIMIT 1');
        $query->execute(array('userid' => $userid));
        $row = $query->fetch();

        if($row){
            $user=new User(array(
                'id'=>$row['id'],
                'email'=>$row['email'],
                'name'=>$row['name'],
                'admin'=>$row['admin'],
                'password'=>$row['password'],
            ));
            return $user;
        }
        return null;
    }



    public static function authenticate($email,$password){
        $query = DB::connection()->prepare('SELECT * FROM usr WHERE email = :email AND password = :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();
        if($row){
            $user=new User(array(
                'id'=>$row['id'],
                'email'=>$row['email'],
                'name'=>$row['name'],
                'password'=>$row['password']
            ));
            return $user;
        }else{
            return null;
        }
    }

    public function save(){
        //tallentaa uuden User-olion tietokantaan
        $query = DB::connection()->prepare('
            INSERT INTO Usr (email, name, password) 
            VALUES (:email, :name, :password) RETURNING id');
        $query->execute(array(
            'email' => $this->email, 
            'name' => $this->name, 
            'password' => $this->password 
            ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }


    
}