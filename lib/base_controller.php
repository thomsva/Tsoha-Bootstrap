<?php

  class BaseController{

    public static function array_flatten($array) { 
      if (!is_array($array)) { 
        return false; 
      } 
      $result = array(); 
      foreach ($array as $key => $value) { 
        if (is_array($value)) { 
          $result = array_merge($result, self::array_flatten($value)); 
        } else { 
          $result[$key] = $value; 
        } 
      } 
      return $result; 
    }

    

    public static function get_user_logged_in(){
      if(isset($_SESSION['userid'])){
        $user=User::find($_SESSION['userid']);
        return $user;
      }
      return null;
    }

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
