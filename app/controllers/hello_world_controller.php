<?php


  class HelloWorldController extends BaseController{



    public static function sandbox(){
      // Testaa koodiasi täällä
      $ekaviini = Wine::find(1);
      $wines = Wine::all();
      // Kint-luokan dump-metodi tulostaa muuttujan arvon
      Kint::dump($wines);
      Kint::dump($ekaviini);
      //View::make('testi.html');
    }

    public static function winelist(){
        View::make('wine_list.html');
    } 

    public static function wineshow(){
        View::make('wine_show.html');
    } 

    public static function winereview(){
        View::make('wine_review.html');
    } 

    public static function signup(){
        View::make('signup.html');
    } 

    public static function login(){
        View::make('login.html');
    } 





  }