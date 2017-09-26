<?php


class WinesController extends BaseController{
    public static function index(){
        $wines=Wine::all();

        View::make('wine/index.html', array('wines'=>$wines));
    }

    public static function wineshow($id){
        $wine=Wine::find($id);
       
        View::make('wine/wine_show.html', array('wine'=>$wine, 'starstring'=>$wine->starstring()));
        
    }

    public static function create(){
        View::make('wine/new.html');        
    }

    public static function store(){
        $params=$_POST;
        $wine= new Wine(array(
            'name' => $params['name'],
            'region' => $params['region'],
            'winetext' => $params['winetext'],
            'type' => $params['type']
        ));
        
        $v = new Valitron\Validator(array('name' => 'Chester Tester'));
        $v->rule('required', 'name');
        if($v->validate()) {
            echo "Yay! We're all good!";
        } else {
            // Errors
            print_r($v->errors());
        }


        $errors=$wine->validate_name();
        Kint::dump($errors);

        Kint::dump($params);
        //$wine->save();

        //Redirect::to('/wine/' . $wine->id, array('message' => 'Viinin lisääminen onnistui!'));
    }

}