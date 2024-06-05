<?php

namespace App\Entity;


use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;
Use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    //#[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeImmutable $date_order = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $supplier_name = '';

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\PositiveOrZero()]
    private ?int $quantity_order = 0;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Products $id_products = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeImmutable $delivered_at = null;

    public function __construct()
    {
        $this->date_order = new \DateTimeImmutable();
    }

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

    public function getIdProducts(): ?Products
    {
        return $this->id_products;
    }

    public function setIdProducts(?Products $id_products): static
    {
        $this->id_products = $id_products;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->delivered_at;
    }

    public function setDeliveredAt(?\DateTimeImmutable $delivered_at): static
    {
        $this->delivered_at = $delivered_at;

        return $this;
    }
}
