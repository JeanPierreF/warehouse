<?php

namespace App\Entity;

use App\Repository\PackagingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackagingsRepository::class)]
class Packagings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity_max = null;

    #[ORM\ManyToOne(inversedBy: 'packagings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?products $id_product = null;

    #[ORM\ManyToOne(inversedBy: 'packagings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?packages $id_packages = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityMax(): ?int
    {
        return $this->quantity_max;
    }

    public function setQuantityMax(int $quantity_max): static
    {
        $this->quantity_max = $quantity_max;

        return $this;
    }

    public function getIdProduct(): ?products
    {
        return $this->id_product;
    }

    public function setIdProduct(?products $id_product): static
    {
        $this->id_product = $id_product;

        return $this;
    }

    public function getIdPackages(): ?packages
    {
        return $this->id_packages;
    }

    public function setIdPackages(?packages $id_packages): static
    {
        $this->id_packages = $id_packages;

        return $this;
    }

}
