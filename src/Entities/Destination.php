<?php
class Destination
{
    private int $id;
    private string $location;
    private int $price;


    public function __construct(int $id, string $location, int $price)
    {
        $this->id = $id;
        $this->location = $location;
        $this->price = $price;
    
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getLocation(): string
    {
        return $this->location;
    }

     public function getPrice(): int
    {
        return $this->price;
    }


    
}
