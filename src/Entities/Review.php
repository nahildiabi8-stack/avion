<?php
class Review
{
    private int $id;
    private string $message;
    private int $author;


    public function __construct(int $id, string $message, int $author)
    {
        $this->id = $id;
        $this->message = $message;
        $this->author = $author;
    
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getMessage(): string
    {
        return $this->message;
    }

     public function getAuthor(): int
    {
        return $this->author;
    }


    
}
