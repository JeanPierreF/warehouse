<?php

namespace App\Services;

use App\Entity\Storages;
use Doctrine\ORM\EntityManagerInterface;

class FindStorageFree
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFreeStorage(): array
    {
        return[];
    }
}
