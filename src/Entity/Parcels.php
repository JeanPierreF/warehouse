<?php

namespace App\Entity;

use App\Repository\ParcelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelsRepository::class)]
class Parcels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $eancode = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?orders $id_order = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?packagings $id_packagings = null;

    #[ORM\OneToMany(targetEntity: StoredIn::class, mappedBy: 'id_parcels')]
    private Collection $storedIns;

    public function __construct()
    {
        $this->storedIns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEancode(): ?string
    {
        return $this->eancode;
    }

    public function setEancode(string $eancode): static
    {
        $this->eancode = $eancode;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIdOrder(): ?orders
    {
        return $this->id_order;
    }

    public function setIdOrder(?orders $id_order): static
    {
        $this->id_order = $id_order;

        return $this;
    }

    public function getIdPackagings(): ?packagings
    {
        return $this->id_packagings;
    }

    public function setIdPackagings(?packagings $id_packagings): static
    {
        $this->id_packagings = $id_packagings;

        return $this;
    }

    /**
     * @return Collection<int, StoredIn>
     */
    public function getStoredIns(): Collection
    {
        return $this->storedIns;
    }

    public function addStoredIn(StoredIn $storedIn): static
    {
        if (!$this->storedIns->contains($storedIn)) {
            $this->storedIns->add($storedIn);
            $storedIn->setIdParcels($this);
        }

        return $this;
    }

    public function removeStoredIn(StoredIn $storedIn): static
    {
        if ($this->storedIns->removeElement($storedIn)) {
            // set the owning side to null (unless already changed)
            if ($storedIn->getIdParcels() === $this) {
                $storedIn->setIdParcels(null);
            }
        }

        return $this;
    }
}
