<?php
require_once __DIR__ . '/../Entities/TourOperator.php';
require_once __DIR__ . '/../Entities/Destination.php';
require_once __DIR__ . '/../Entities/Review.php';
require_once __DIR__ . '/../Entities/Score.php';
require_once __DIR__ . '/../Entities/Certificate.php';
require_once __DIR__ . '/../Entities/Author.php';


class Manager
{
    private PDO $bdd;

    public function __construct()
    {
        $this->bdd = new PDO(
            'mysql:host=localhost;dbname=aeroport;charset=utf8',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    // =============================================
    // DESTINATIONS
    // =============================================

    public function getAllDestinations(): array
    {
        $stmt = $this->bdd->query('SELECT * FROM destination');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $destinations = [];
        foreach ($rows as $row) {
            $destinations[] = new Destination($row['id'], $row['location'], $row['price']);
        }

        return $destinations;
    }

    public function getAuthorByName(string $nom, string $prenom): ?Author
    {
        $stmt = $this->bdd->prepare('SELECT * FROM author WHERE nom = :nom AND prenom = :prenom');
        $stmt->execute([':nom' => $nom, ':prenom' => $prenom]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Author($row['id'], $row['nom'], $row['prenom'], $row['age'], $row['sexe']);
    }

    public function createDestination(string $location, int $price, int $tourOperatorId): void
    {
        $stmt = $this->bdd->prepare('INSERT INTO destination (location, price, tour_operator_id) VALUES (:location, :price, :tour_operator_id)');
        $stmt->execute([
            ':location' => $location,
            ':price' => $price,
            ':tour_operator_id' => $tourOperatorId
        ]);
    }

    // =============================================
    // TOUR OPERATORS
    // =============================================

    public function getAllOperators(): array
    {
        $stmt = $this->bdd->query('SELECT * FROM tour_operator');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $operators = [];
        foreach ($rows as $row) {
            $operators[] = $this->buildTourOperator($row);
        }

        return $operators;
    }

    public function getDestinationById(int $id): ?Destination
    {
        $stmt = $this->bdd->prepare('SELECT * FROM destination WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Destination($row['id'], $row['location'], $row['price']);
    }

    public function getOperatorsByDestination(int $destinationId): array
    {
        $stmt = $this->bdd->prepare('
            SELECT tour_operator.* FROM tour_operator
        JOIN destination ON destination.tour_operator_id = tour_operator.id
        WHERE destination.id = :destination_id
        ');
        $stmt->execute([':destination_id' => $destinationId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $operators = [];
        foreach ($rows as $row) {
            $operators[] = $this->buildTourOperator($row);
        }

        return $operators;
    }

    public function createTourOperator(string $name, string $link): void
    {
        $stmt = $this->bdd->prepare('INSERT INTO tour_operator (name, link) VALUES (:name, :link)');
        $stmt->execute([
            ':name' => $name,
            ':link' => $link
        ]);
    }

    public function updateOperatorToPremium(int $tourOperatorId, string $signatory): void
    {
        $stmt = $this->bdd->prepare('
            INSERT INTO certificate (tour_operator_id, expires_at, signatory)
            VALUES (:tour_operator_id, DATE_ADD(NOW(), INTERVAL 1 YEAR), :signatory)
        ');
        $stmt->execute([
            ':tour_operator_id' => $tourOperatorId,
            ':signatory' => $signatory
        ]);
    }

    // =============================================
    // REVIEWS
    // =============================================

    public function getReviewsByOperatorId(int $tourOperatorId): array
    {
        $stmt = $this->bdd->prepare('SELECT * FROM review WHERE tour_operator_id = :tour_operator_id');
        $stmt->execute([':tour_operator_id' => $tourOperatorId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $reviews = [];
        foreach ($rows as $row) {
            $reviews[] = new Review($row['id'], $row['message'], $row['author_id']);
        }

        return $reviews;
    }

    public function createReview(string $message, int $tourOperatorId, int $authorId, int $grade = 0): void
    {
        // Sauvegarde la review
        $stmt = $this->bdd->prepare('INSERT INTO review (message, tour_operator_id, author_id) VALUES (:message, :tour_operator_id, :author_id)');
        $stmt->execute([
            ':message' => $message,
            ':tour_operator_id' => $tourOperatorId,
            ':author_id' => $authorId
        ]);

        // Sauvegarde le score
        $stmt2 = $this->bdd->prepare('INSERT INTO score (value, tour_operator_id, author_id) VALUES (:value, :tour_operator_id, :author_id)');
        $stmt2->execute([
            ':value' => $grade,
            ':tour_operator_id' => $tourOperatorId,
            ':author_id' => $authorId
        ]);
    }

    // =============================================
    // SCORES
    // =============================================

    public function getScoresByOperatorId(int $tourOperatorId): array
    {
        $stmt = $this->bdd->prepare('SELECT * FROM score WHERE tour_operator_id = :tour_operator_id');
        $stmt->execute([':tour_operator_id' => $tourOperatorId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $scores = [];
        foreach ($rows as $row) {
            $scores[] = new Score($row['id'], $row['value'], $row['author_id']);
        }

        return $scores;
    }

    // =============================================
    // AUTHORS
    // =============================================

    public function createAuthor(string $nom, string $prenom, int $age, string $sexe): int
    {
        $stmt = $this->bdd->prepare('INSERT INTO author (nom, prenom, age, sexe) VALUES (:nom, :prenom, :age, :sexe)');
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':age' => $age,
            ':sexe' => $sexe
        ]);

        return (int) $this->bdd->lastInsertId();
    }

    public function getAuthorById(int $id): ?Author
    {
        $stmt = $this->bdd->prepare('SELECT * FROM author WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Author($row['id'], $row['name'], $row['prenom'], $row['age'], $row['sexe']);
    }

    // =============================================
    // HELPER PRIVÉ
    // =============================================

    private function buildTourOperator(array $row): TourOperator
    {
        $reviews = $this->getReviewsByOperatorId($row['id']);
        $scores = $this->getScoresByOperatorId($row['id']);

        // Récupère le certificat si premium
        $stmt = $this->bdd->prepare('SELECT * FROM certificate WHERE tour_operator_id = :id');
        $stmt->execute([':id' => $row['id']]);
        $certRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $certificate = null;
        if ($certRow) {
            $certificate = new Certificate(new \DateTime($certRow['expires_at']), $certRow['signatory']);
        }

        $destinations = [];
        $stmt = $this->bdd->prepare('SELECT * FROM destination WHERE tour_operator_id = :id');
        $stmt->execute([':id' => $row['id']]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dest) {
            $destinations[] = new Destination($dest['id'], $dest['location'], $dest['price']);
        }

        return new TourOperator(
            $row['id'],
            $row['name'],
            $row['link'] ?? '',
            $certificate,
            $destinations,
            $reviews,
            $scores
        );
    }
}
