<?php

namespace App\Entity;

use App\Repository\PackagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
Use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PackagesRepository::class)]
class Packages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?int $length = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?int $width = null;

    #[ORM\Column]
    #[Assert\Positive()]
    private ?int $height = null;

    #[ORM\Column]
    private ?bool $palletizable = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    private ?int $occupancy = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $storage = null;

    #[ORM\OneToMany(targetEntity: Products::class, mappedBy: 'id_packages')]
    private Collection $products;

    #[ORM\OneToMany(targetEntity: Packagings::class, mappedBy: 'id_packages')]
    private Collection $packagings;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->packagings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function isPalletizable(): ?bool
    {
        return $this->palletizable;
    }

    public function setPalletizable(bool $palletizable): static
    {
        $this->palletizable = $palletizable;

        return $this;
    }

    public function getOccupancy(): ?int
    {
        return $this->occupancy;
    }

    public function setOccupancy(int $occupancy): static
    {
        $this->occupancy = $occupancy;

        return $this;
    }

    public function getStorage(): ?string
    {
        return $this->storage;
    }

    public function setStorage(string $storage): static
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setIdPackages($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getIdPackages() === $this) {
                $product->setIdPackages(null);
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
            $packaging->setIdPackages($this);
        }

        return $this;
    }

    public function removePackaging(Packagings $packaging): static
    {
        if ($this->packagings->removeElement($packaging)) {
            // set the owning side to null (unless already changed)
            if ($packaging->getIdPackages() === $this) {
                $packaging->setIdPackages(null);
            }
        }

        return $this;
    }

  

}
