<?php
        use Valitron\Validator as V;
        
                V::langDir('vendor/vlucas/valitron/lang'); // always set langDir before lang.
                V::lang('fi');

class WinesController extends BaseController{
    
    public static function index(){
        $wines=Wine::all();

        $user=self::get_user_logged_in();        
        
        View::make('wine/index.html', array('wines'=>$wines, 'user_logged_in'=>$user));
    }

    public static function wineshow($id){
        $wine=Wine::find($id);
        $user=self::get_user_logged_in();

        
        View::make('wine/wine_show.html', array('wine'=>$wine, 'starstring'=>$wine->starstring(), 'user_logged_in'=>$user));
        
    }

    public static function create(){
        View::make('wine/new.html');        
    }

    public static function store(){
        $params=$_POST;
       

        


        $v = new Valitron\Validator($_POST);
        $v->rule('required', 'name')->message('Nimi on pakollinen tieto!');
        $v->rule('lengthBetween',3,30, 'name')->message('Nimen pituus virheellinen!');
        $v->rule('required', 'region');


        if($v->validate()) {
            $wine= new Wine(array(
                'name' => $params['name'],
                'region' => $params['region'],
                'winetext' => $params['winetext'],
                'type' => $params['type']
            ));
            //Kint::dump($params);
            Kint::dump($v->errors());
            //Redirect::to('/wine/wine_show.html' . $wine->id, array('message' => 'Viinin lisääminen onnistui!','error'=>$v->errors()));
        } else {
            
            $errors=$v->errors();
            Kint::trace();
            Kint::dump($errors);
            Redirect::to('/wine/new' , array($params, 'message' => 'Viinin lisääminen epäonnistui!'), $errors);
        }
        


        //Kint::dump($errors);

        //Kint::dump($params);
        //$wine->save();

        
    }

}