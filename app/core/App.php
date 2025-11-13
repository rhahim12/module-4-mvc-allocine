<?php
require_once(__DIR__. "/../models/FilmModel.php");
class App{
    public static function start(){
        echo "App";
        // console("App");
        
        // console(new FilmEntity("rhahim",new DateTime("2025-11-12"),"Action","Yoga"));
        $filmModel = new FilmModel();
    
        $films = $filmModel->add("ninho",new DateTime("now"),"Fantastique","abou");
       
        console($films);
        // foreach($films as $film){
            // console($film->getName());
        // }

       
    }
}