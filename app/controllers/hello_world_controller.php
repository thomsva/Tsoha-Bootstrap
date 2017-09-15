<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
       View::make('wine_list.html');
       //echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('testi.html');
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