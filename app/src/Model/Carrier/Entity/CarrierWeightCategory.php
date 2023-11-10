<?php

namespace App\Model\Carrier\Entity;

use App\Model\Carrier\CarrierWeightCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierWeightCategoryRepository::class)]
class CarrierWeightCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $carrier_id = null;

    #[ORM\Column]
    private ?int $beginning = null;

    #[ORM\Column]
    private ?int $ending = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'categorys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carrier $carrier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrierId(): ?int
    {
        return $this->carrier_id;
    }

    public function setCarrierId(int $carrier_id): static
    {
        $this->carrier_id = $carrier_id;

        return $this;
    }

    public function getBeginning(): ?int
    {
        return $this->beginning;
    }

    public function setBeginning(int $beginning): static
    {
        $this->beginning = $beginning;

        return $this;
    }

    public function getEnding(): ?int
    {
        return $this->ending;
    }

    public function setEnding(int $ending): static
    {
        $this->ending = $ending;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): static
    {
        $this->carrier = $carrier;

        return $this;
    }
}
