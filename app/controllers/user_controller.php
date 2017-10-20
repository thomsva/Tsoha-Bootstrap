<?php

class UsersController extends BaseController{

    private static function validate_inputs($v){
        // Validoitiin käytetään Valitron\Validator luokan ilmentymää. 
        // Tämä funktio tarkistaa wine -luokan ilmentymään syötettävää
        // tietoa Valitronin palveluita hyödyntäen. 
        $v->rule('lengthMax', 'email',50)->message('Sähköposti entintään 30 merkkiä');
        $v->rule('required', 'email')->message('Sähköposti vaaditaan'); 
        $v->rule('required', 'password')->message('Anna myös salasana'); 
        $v->rule('equals', 'password', 'password_confirm')->message('Salasanat eivät täsmää'); 
        $v->rule('email', 'email')->message('Sähköpostiosoite ei kelpaa'); 

        return $v->validate();
    }

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

    public static function signup(){
        View::make('user/signup.html');
    } 


    public static function store(){
        $params=$_POST;
        $v = new Valitron\Validator($params); 
        $unique=User::unique($params['email']);
        
        if(self::validate_inputs($v) and $unique) {
            $user= new User(array(
                'email' => $params['email'],
                'name' => $params['name'],
                'password' => $params['password']
            ));
            $user->save();
            $_SESSION['userid'] = $user->id;
            Redirect::to('/', array('message' => 'Tervetuloa käyttäjäksi ' . $user->name . '!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Kint::dump($errors);
            Kint::dump($unique);
            //Redirect::to('/signup' , array('user' => $params, 'errors' => $errors));
        }      
    }

}