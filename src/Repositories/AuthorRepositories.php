<?php
class AuthorRepositories
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Author $author): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO author ( id, nom, prenom, age, sexe) VALUES (:id, :nom, :prenom, :age, :sexe)"
        );
        $stmt->execute([
            ':id' => $author->getId(),
            ':nom'   => $author->getFirstName(),
            ':prenom'   => $author->getName(),
            ':age' => $author->getAge(),
            ':sexe' => $author->getSexe(),
        ]);
    }
}
