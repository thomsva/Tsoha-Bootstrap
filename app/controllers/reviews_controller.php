<?php

class ReviewsController extends BaseController{

    private static function validate_inputs($v){
        // Validoitiin käytetään Valitron\Validator luokan ilmentymää. 
        // Tämä funktio tarkistaa wine -luokan ilmentymään syötettävää
        // tietoa Valitronin palveluita hyödyntäen. 
        $v->rule('lengthMax', 'reviewtext',500)->message('Kuvaus entintään 500 merkkiä');
        $v->rule('required', 'stars')->message('1-5 tähteä vaaditaan'); 
        return $v->validate();
    }

    public static function create($wineid){
        $user=self::get_user_logged_in();
        Kint::trace();
        Kint::dump($wineid);
        if($user){
            View::make('/review/new.html');  
        }else{
            View::make('user/login.html', array('message' => 'Kirjaudu ensin sisään!'));
        }      
    }

    public static function store(){
        $params=$_POST;
        $v = new Valitron\Validator($params); 
        if(self::validate_inputs($v)) {
            $veview= new Review(array(
                'userid' => $params['userid'],
                'wineid' => $params['wineid'],
                'reviewtext' => $params['reviewtext'],
                'stars' => $params['stars']
            ));
            $review->save();
            Redirect::to('/wine/'.$review->wineid, array('message' => 'Arvion lisääminen onnistui!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Redirect::to('/review/new' , array('review' => $params, 'errors' => $errors));
        }      
    }

    public static function edit($id){
        $wine=Wine::find($id);
        $user=self::get_user_logged_in();
        if($user){
            View::make('wine/edit.html', array('wine'=>$wine, 'user_logged_in'=>$user));
        }else{
            View::make('user/login.html', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function retry_edit($id){
        // Kun käyttäjän tietoja ei hyväksytty.
        // Tehdään uusi lomake käyttäjän antamilla tiedoilla korjausta varten. 
        $params=$_POST;;
        $user=self::get_user_logged_in();
        View::make('wine/edit.html', array('wine'=>$params, 'user_logged_in'=>$user));
    }

    public static function update(){
        $params=$_POST;
        $v = new Valitron\Validator($params); 
        if(self::validate_inputs($v)) {
            $wine= new Wine(array(
                'id' => $params['id'],
                'name' => $params['name'],
                'region' => $params['region'],
                'winetext' => $params['winetext'],
                'type' => $params['type']
            ));
            $wine->update();
            Redirect::to('/wine/' . $wine->id, array('message' => 'Tietojen muokkaaminen onnistui!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Redirect::to('/wine/edit/' . $params['id'] , array('wine'=>$params, 'errors' => $errors));
        }  
    }

    public static function destroy($id){
        $wine = Wine::find($id);
        $name = $wine->name;
        $wine->destroy();
        Redirect::to('/', array('message' => 'Viini '. $name .' on poistettu tietokannasta!'));
    }
}