<?php
class FilmModel {


    private PDO $bdd;
    private PDOStatement $getFilms;
    private PDOStatement $addFilm;







    function __construct(){
        $this->bdd = new PDO("mysql:host=bdd;dbname=allocine","root","root");
 
        $this-> getFilms = $this->bdd->prepare("SELECT * FROM `Film` LIMIT :limit");

        $this->addFilm = $this->bdd->prepare("INSERT INTO `Film`(name,date,gender,autor) VALUE(:name,:date,:gender,:autor) ");
    }


    public function getAll(int $limit = 50) : array{

        $this->getFilms->bindValue("limit", $limit, PDO::PARAM_INT);

        $this->getFilms->execute();

        $rawFilms = $this->getFilms->fetchAll();

        $filmsEntity = [];
        foreach($rawFilms as $rawFilm){
            $filmsEntity[] = new FilmEntity(
                $rawFilm["name"],
                $rawFilm["date_sortie"] = new DateTime(),
                $rawFilm["gender"],
                $rawFilm["autor"],
                $rawFilm["id"]
            );
        }
        return $filmsEntity;
    }

    public function add(string $name, DateTime $date, string $gender, string $autor): void{
        $this->addFilm->bindValue("name", $name);
        $this->addFilm->bindValue("date", $date->getTimestamp(),PDO::PARAM_STR);
        $this->addFilm->bindValue("gender", $gender);
        $this->addFilm->bindValue("autor", $autor);
        $this->addFilm->execute();


    }
}







class FilmEntity
{
    private $id;
    private $name;
    private DateTime $date;
    private $gender;
    private $autor;

    private const NAME_MIN_LENGTH = 3;
    private const GENDER_MIN_LENGTH = 2;
    private const DEFAULT_IMG_URL = "/public/images/default.png";


    function __construct(string $name, DateTime $date, string $gender, string $autor, int $id = null)
    {
        $this->setName($name);
        $this->date = $date;
        $this->setGender($gender);
        $this->setAutor($autor);
        $this->id = $id;
    }

     public function setName(string $name)
    {
        if (strlen($name) < $this::NAME_MIN_LENGTH) {
            throw new Error("Name is too short minimum 
            length is " . $this::NAME_MIN_LENGTH);
        }
        $this->name = $name;
    }

    public function setDate(DateTime $date){

        $this->$date = $date;

    }
     public function setGender($gender){
        if (strlen($gender) < $this::GENDER_MIN_LENGTH) {
            throw new Error("Name is too short minimum 
            length is " . $this::GENDER_MIN_LENGTH);
        }
        $this->gender = $gender;
        
    }
     public function setAutor(string $autor){
        if (strlen($autor) < $this::NAME_MIN_LENGTH) {
            throw new Error("Name is too short minimum 
            length is " . $this::NAME_MIN_LENGTH);
        }
        $this->autor = $autor;        
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getId(): int
    { 
        return $this->id;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public function getGender(): string
    {
        return $this->gender;
    }
    public function getAutor(): string
    {
        return $this->autor;
    }
}

// timestamp