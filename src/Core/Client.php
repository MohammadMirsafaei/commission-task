<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

class Client
{
    public const PRIVATE_CLIENT = 1;

    public const BUSINESS_CLIENT = 2;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $clientType;

    /**
     * @var Transaction[]
     */
    private array $transactions;
    
    /**
     * @param int $id
     * @param int $clientType
     */
    public function __construct(int $id, int $clientType)
    {
        $this->id = $id;
        $this->clientType = $clientType;
    }

    /**
     * Returns id of client
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns type of client
     * @return int
     */
    public function getType(): int
    {
        return $this->clientType;
    }
    
    /**
     * Returns transactions of client
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }
}