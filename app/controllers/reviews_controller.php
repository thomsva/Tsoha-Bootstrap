<?php

class ReviewsController extends BaseController{

    private static function validate_inputs($v){
        // Validoitiin käytetään Valitron\Validator luokan ilmentymää. 
        // Tämä funktio tarkistaa wine -luokan ilmentymään syötettävää
        // tietoa Valitronin palveluita hyödyntäen. 
        $v->rule('lengthMax', 'reviewtext',500)->message('Kuvaus entintään 500 merkkiä');
        $v->rule('required', 'reviewtext')->message('Kuvaus vaaditaan'); 
        $v->rule('required', 'stars')->message('1-5 tähteä vaaditaan'); 
        return $v->validate();
    }

    public static function create($wineid){
        $user=self::get_user_logged_in();
        $wine=Wine::find($wineid);
        $tags=Tag::all();
        //Kint::trace();
        //Kint::dump($wineid);
        if($user){
            View::make('/review/new.html', array('wine'=>$wine, 'tags'=>$tags));  
        }else{
            View::make('user/login.html', array('message' => 'Kirjaudu ensin sisään!'));
        }      
    }

    public static function store(){
        $params=$_POST;

        $user=self::get_user_logged_in();
        $v = new Valitron\Validator($params); 
        if(self::validate_inputs($v)) {
            $review= new Review(array(
                'userid' => $user->id,
                'wineid' => $params['wineid'],
                'reviewtext' => $params['reviewtext'],
                'stars' => $params['stars'],
                'tags' => $params['tags']
            ));
            Kint::dump($review);

            $review->save();
            Redirect::to('/wine/'.$review->wineid, array('message' => 'Arvion lisääminen onnistui!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Redirect::to('/review/new/'.$params['wineid'] , array('review' => $params, 'errors' => $errors));
        }      
    }

    public static function edit($id){
        $review=Review::find($id);
        $wine=Wine::find($review->wineid);
        $review->tags();
        $tags=Tag::all();
        $user=self::get_user_logged_in();
        if($user){
            View::make('review/edit.html', array('review'=>$review, 'wine'=>$wine, 'tags'=>$tags));
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
        $user=self::get_user_logged_in();
        $v = new Valitron\Validator($params); 
        if(self::validate_inputs($v)) {
            $review= new Review(array(
                'id' => $params['id'],
                'userid' => $user->id,
                'wineid' => $params['wineid'],
                'reviewtext' => $params['reviewtext'],
                'stars' => $params['stars'],
                'tags' => $params['tags']
            ));
            $review->update();           
            Redirect::to('/wine/' . $review->wineid, array('message' => 'Arvion muokkaaminen onnistui!!'));
        }else{
            // Valitronin tuottamat virheviestit litistetään yksinkertaiseksi listaksi
            $errors=self::array_flatten($v->errors());
            Redirect::to('/review/edit/' . $params['id'] , array('review'=>$params, 'errors' => $errors));
        }  
    }

    public static function destroy($reviewid){
        $review = Review::find($reviewid);
        $wineid=$review->wineid;
        $review->destroy();
        Redirect::to('/wine/'.$wineid, array('message' => 'Arvio on poistettu tietokannasta!'));
    }
}