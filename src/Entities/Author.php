<?php
class Author
{
    private int $id;
    private string $nom;
    private string $prenom;
    private int $age;
    private string $sexe;
    

    public function __construct(int $id, string $nom, string $prenom, int $age, string $sexe,)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->sexe = $sexe;
    
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getFirstName(): string
    {
        return $this->prenom;
    }


    public function getName(): string
    {
        return $this->nom;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSexe(): string
    {
        return $this->sexe;
    }

   
}
