<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $date_order = null;

    #[ORM\Column(length: 255)]
    private ?string $supplier_name = null;

    #[ORM\Column]
    private ?int $quantity_order = 0;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?products $id_products = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOrder(): ?\DateTimeImmutable
    {
        return $this->date_order;
    }

    public function setDateOrder(\DateTimeImmutable $date_order): static
    {
        $this->date_order = $date_order;

        return $this;
    }

    public function getSupplierName(): ?string
    {
        return $this->supplier_name;
    }

    public function setSupplierName(string $supplier_name): static
    {
        $this->supplier_name = $supplier_name;

        return $this;
    }

    public function getQuantityOrder(): ?int
    {
        return $this->quantity_order;
    }

    public function setQuantityOrder(int $quantity_order): static
    {
        $this->quantity_order = $quantity_order;

        return $this;
    }

    public function getIdProducts(): ?products
    {
        return $this->id_products;
    }

    public function setIdProducts(?products $id_products): static
    {
        $this->id_products = $id_products;

        return $this;
    }
}
