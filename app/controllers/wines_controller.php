<?php


class WinesController extends BaseController{
    public static function index(){
        $wines=Wine::all();
        View::make('wine/index.html', array('wines'=>$wines));
    }

    public static function wineshow($id){
        $wine=Wine::find($id);
        View::make('wine/wine_show.html', array('wine'=>$wine));
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
        
        //Kint::dump($params);
        $wine->save();

        Redirect::to('/wine/' . $wine->id, array('message' => 'Viinin lisääminen onnistui!'));
    }

}