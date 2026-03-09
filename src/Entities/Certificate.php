<?php
class Certificate
{
    private \DateTime $expiresAt;
    private string $signatory;


    public function __construct( \DateTime $expiresAt,  string $signatory)
    {
      
        $this->expiresAt = $expiresAt;
        $this->signatory = $signatory;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function getSignatory(): string
    {
        return $this->signatory;
    }
}
