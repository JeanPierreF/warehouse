<?php

namespace App\Entity;

use App\Repository\StoragesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoragesRepository::class)]
class Storages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\OneToMany(targetEntity: StoredIn::class, mappedBy: 'id_storages')]
    private Collection $storedIns;

    public function __construct()
    {
        $this->storedIns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

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
            $storedIn->setIdStorages($this);
        }

        return $this;
    }

    public function removeStoredIn(StoredIn $storedIn): static
    {
        if ($this->storedIns->removeElement($storedIn)) {
            // set the owning side to null (unless already changed)
            if ($storedIn->getIdStorages() === $this) {
                $storedIn->setIdStorages(null);
            }
        }

        return $this;
    }
}
