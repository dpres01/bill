<?php

namespace App\Entity;

use App\Repository\BilledMakerRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilledMakerRepository::class)]
class BilledMaker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Billed $billedRef = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $billedDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $startAtPeriod = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $endAtPeriod = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $paymentAt;

    public function __construct()
    {
        $this->startAtPeriod = new DateTimeImmutable('first day of this month');
        $this->endAtPeriod = new DateTimeImmutable('last day of this month');
        $this->paymentAt = $this->startAtPeriod->modify('+4 days');// new DateTimeImmutable('five day of this month');
        $this->billedDate = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBilledRef(): ?Billed
    {
        return $this->billedRef;
    }

    public function setBilledRef(?Billed $billedRef): static
    {
        $this->billedRef = $billedRef;

        return $this;
    }

    public function getBilledDate(): ?DateTimeImmutable
    {
        return $this->billedDate;
    }

    public function setBilledDate(DateTimeImmutable $billedDate): static
    {
        $this->billedDate = $billedDate;

        return $this;
    }

    public function getStartAtPeriod(): ?DateTimeImmutable
    {
        return $this->startAtPeriod;
    }

    public function setStartAtPeriod(DateTimeImmutable $startAtPeriod): static
    {
        $this->startAtPeriod = $startAtPeriod;

        return $this;
    }

    public function getEndAtPeriod(): ?DateTimeImmutable
    {
        return $this->endAtPeriod;
    }

    public function setEndAtPeriod(DateTimeImmutable $endAtPeriod): static
    {
        $this->endAtPeriod = $endAtPeriod;

        return $this;
    }

    public function getPaymentAt(): DateTimeImmutable
    {
        return $this->paymentAt;
    }
 
    public function setPaymentAt(DateTimeImmutable $paymentAt): static
    {
        $this->paymentAt = $paymentAt;

        return $this;
    }
}
