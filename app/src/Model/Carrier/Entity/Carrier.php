<?php

namespace App\Model\Carrier\Entity;

use App\Model\Carrier\CarrierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $weight_categoring = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $price_uncategorized = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isWeightCategoring(): ?bool
    {
        return $this->weight_categoring;
    }

    public function setWeightCategoring(bool $weight_categoring): static
    {
        $this->weight_categoring = $weight_categoring;

        return $this;
    }

    public function getPriceUncategorzed(): ?string
    {
        return $this->price_uncategorized;
    }

    public function setPriceUncategorized(?string $price_uncategorized): static
    {
        $this->price_uncategorized = $price_uncategorized;

        return $this;
    }
}
