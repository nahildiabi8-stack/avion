<?php
class TourOperator
{
    private int $id;
    private string $name;
    private string $link;
    private ?Certificate $certificate;  // null si pas premium
    private array $destinations;        // tableau de Destination
    private array $reviews;             // tableau de Review
    private array $scores;              // tableau de Score


    public function __construct(int $id, string $name, string $link, ?Certificate $certificate, array $destinations, array $reviews, array $scores,)
    {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
        $this->certificate = $certificate;
        $this->destinations = $destinations;
        $this->reviews = $reviews;
        $this->scores = $scores;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLink(): string
    {
        return $this->link;
    }
    public function getDestinations(): array
    {
        return $this->destinations;
    }
    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGrade(): float
    {
        if (empty($this->scores)) {
            return 0;
        }

        $total = 0;
        foreach ($this->scores as $score) {
            $total += $score->getValue();
        }

        return $total / count($this->scores);
    }

    public function isPremium(): bool
    {
        return $this->certificate !== null;
    }
}
