<?php

namespace App\Entity;

use App\Repository\BilledRepository;
use ArrayAccess;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilledRepository::class)]
class Billed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $renter = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $owner = null;


    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $chargesAmount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, BuilledMaker>
     */
    #[ORM\OneToMany(targetEntity: BilledMaker::class, mappedBy: 'billedRef')]
    private Collection $invoices;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        
        return $this;
        $this->amount = $amount;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getChargesAmount(): ?float
    {
        return $this->chargesAmount;
    }

    public function setChargesAmount(float $chargesAmount): static
    {
        $this->chargesAmount = $chargesAmount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRenter(): ?Person
    {
        return $this->renter;
    }

    public function setRenter(?Person $renter): self
    {
        $this->renter = $renter;

        return $this;
    }

    public function getOwner(): ?Person
    {
        return $this->owner;
    }

    public function setOwner(?Person $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, BuilledMaker>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoices(BilledMaker $invoices): static
    {
        if (!$this->invoices->contains($invoices)) {
            $this->invoices->add($invoices);
            $invoices->setBilledRef($this);
        }

        return $this;
    }

    public function removeInvoices(BilledMaker $invoices): static
    {
        if ($this->invoices->removeElement($invoices)) {
            // set the owning side to null (unless already changed)
            if ($invoices->getBilledRef() === $this) {
                $invoices->setBilledRef(null);
            }
        }

        return $this;
    }

}
