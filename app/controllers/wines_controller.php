<?php

class WinesController extends BaseController{

    private static function validate_inputs($v){
        // Validoitiin käytetään Valitron\Validator luokan ilmentymää. 
        // Tämä funktio tarkistaa wine -luokan ilmentymään syötettävää
        // tietoa Valitronin palveluita hyödyntäen. 
        $v->rule('required', 'name')->message('Nimi vaaditaan'); 
        $v->rule('lengthMax','name',30)->message('Nimi entintään 30 merkkiä');
        $v->rule('required', 'region')->message('Alkuperä (alue) vaaditaan'); 
        $v->rule('lengthMax', 'region',30)->message('Alkuperä (alue) entintään 30 merkkiä');
        $v->rule('lengthMax', 'winetext',500)->message('Kuvaus entintään 500 merkkiä');
        $v->rule('required', 'type')->message('Tyyppi vaaditaan'); 
        $v->rule('lengthMax', 'type',30)->message('Tyyppi entintään 30 merkkiä');
        return $v->validate();
    }
    
    public static function index(){
        $wines=Wine::all();
        $user=self::get_user_logged_in();        
        View::make('wine/index.html', array('wines'=>$wines, 'user_logged_in'=>$user));
    }

    public static function wineshow($id){
        $wine=Wine::find($id);
        $reviews=Review::all($id);
        kint::dump($reviews);
        $user=self::get_user_logged_in();
        foreach($reviews as $r){
            $r->tags();
        }     
        View::make('wine/wine_show.html', array('wine'=>$wine, 'starstring'=>$wine->starstring(),
            'user_logged_in'=>$user, 'reviews'=>$reviews));
    }

    public static function create(){
        $user=self::get_user_logged_in();
        if($user){
            View::make('wine/new.html');  
        }else{
            View::make('user/login.html', array('message' => 'Kirjaudu ensin sisään!'));
        }      
    }

    public static function store(){
        $params=$_POST;
        $v = new Valitron\Validator($params); 
        if(self::validate_inputs($v)) {
            $wine= new Wine(array(
                'name' => $params['name'],
                'region' => $params['region'],
                'winetext' => $params['winetext'],
                'type' => $params['type']
            ));
            $wine->save();
            Redirect::to('/wine/'.$wine->id, array('message' => 'Viinin lisääminen onnistui!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Redirect::to('/wine/new' , array('wine' => $params, 'errors' => $errors));
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