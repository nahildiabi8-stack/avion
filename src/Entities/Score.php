<?php
class Score
{
    private int $id;
    private int $value;
    private int $author;


    public function __construct(int $id, int $value, int $author)
    {
        $this->id = $id;
        $this->value = $value;
        $this->author = $author;
    
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getValue(): int
    {
        return $this->value;
    }

     public function getAuthor(): int
    {
        return $this->author;
    }


    
}
