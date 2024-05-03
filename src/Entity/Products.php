<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
Use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /* #[Assert\Length(min: 3, max: 255, minMessage: 'Pour le nom des produits il faut 3 carartéres minimun.', maxMessage: 'Pour le nom des produits il faut 255 carartéres maximun.')]     */
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?packages $id_packages = null;

    #[ORM\OneToMany(targetEntity: Orders::class, mappedBy: 'id_products')]
    private Collection $orders;

    #[ORM\OneToMany(targetEntity: Packagings::class, mappedBy: 'id_product')]
    private Collection $packagings;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->packagings = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setIdProducts($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getIdProducts() === $this) {
                $order->setIdProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Packagings>
     */
    public function getPackagings(): Collection
    {
        return $this->packagings;
    }

    public function addPackaging(Packagings $packaging): static
    {
        if (!$this->packagings->contains($packaging)) {
            $this->packagings->add($packaging);
            $packaging->setIdProduct($this);
        }

        return $this;
    }

    public function removePackaging(Packagings $packaging): static
    {
        if ($this->packagings->removeElement($packaging)) {
            // set the owning side to null (unless already changed)
            if ($packaging->getIdProduct() === $this) {
                $packaging->setIdProduct(null);
            }
        }

        return $this;
    }
}
