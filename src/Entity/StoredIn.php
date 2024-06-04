<?php

namespace App\Entity;

use App\Repository\StoredInRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoredInRepository::class)]
class StoredIn
{
    #[ORM\Column (options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $entered_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $released_on = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'storedIns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parcels $id_parcels = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'storedIns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Storages $id_storages = null;

    public function __construct()
    {
        $this->entered_at = new \DateTimeImmutable();
    }

    public function getEnteredAt(): ?\DateTimeImmutable
    {
        return $this->entered_at;
    }

    public function setEnteredAt(\DateTimeImmutable $entered_at): static
    {
        $this->entered_at = $entered_at;

        return $this;
    }

    public function getReleasedOn(): ?\DateTimeImmutable
    {
        return $this->released_on;
    }

    public function setReleasedOn(\DateTimeImmutable $released_on): static
    {
        $this->released_on = $released_on;

        return $this;
    }

    public function getIdParcels(): ?Parcels
    {
        return $this->id_parcels;
    }

    public function setIdParcels(?Parcels $id_parcels): static
    {
        $this->id_parcels = $id_parcels;

        return $this;
    }

    public function getIdStorages(): ?Storages
    {
        return $this->id_storages;
    }

    public function setIdStorages(?Storages $id_storages): static
    {
        $this->id_storages = $id_storages;

        return $this;
    }
}
