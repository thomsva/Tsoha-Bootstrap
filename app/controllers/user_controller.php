<?php

class UsersController extends BaseController{

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login(){
        $params = $_POST;
    
        $user = User::authenticate($params['email'], $params['password']);
    
        if(!$user){
            $errors = array('error'=>'Väärä käyttäjätunnus tai salasana!');
            View::make('user/login.html', array('errors' => $errors, 'email' => $params['email']));
        }else{
            $_SESSION['userid'] = $user->id;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
        }
    }

    public static function logout(){
        unset($_SESSION["userid"]);
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));


    }

}