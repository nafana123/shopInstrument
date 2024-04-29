<?php

namespace App\Entity;

use App\Repository\InfoProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoProductRepository::class)]
class InfoProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_product = null;
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 1255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $sale = null;

    #[ORM\Column(length: 255)]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 255)]
    private ?string $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $volume = null;

    #[ORM\Column(length: 255)]
    private ?string $voltage= null;

    #[ORM\Column(length: 255)]
    private ?string $rown= null;

    #[ORM\Column(length: 255)]
    private ?string $engine= null;

    #[ORM\Column(length: 255)]
    private ?string $power = null;

    #[ORM\Column(length: 255)]
    private ?string $mixtures = null;

    #[ORM\Column(length: 255)]
    private ?string $time = null;
    #[ORM\Column(length: 255)]
    private ?string $drive = null;
    #[ORM\Column(length: 255)]
    private ?string $retainer = null;

    #[ORM\Column(length: 255)]
    private ?string $connections = null;

    #[ORM\Column(length: 255)]
    private ?string $wheels = null;

    #[ORM\Column(length: 255)]
    private ?string $dimensions = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $motherland = null;

    #[ORM\Column(length: 255)]
    private ?string $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getIdProduct(): ?string
    {
        return $this->id_product;
    }

    public function setIdProduct(string $id_product): static
    {
        $this->id_product = $id_product;

        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSale(): ?string
    {
        return $this->sale;
    }

    public function setSale(string $sale): static
    {
        $this->sale = $sale;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): void
    {
        $this->stock = $stock;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): void
    {
        $this->weight = $weight;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): void
    {
        $this->volume = $volume;
    }

    public function getVoltage(): ?string
    {
        return $this->voltage;
    }

    public function setVoltage(?string $voltage): void
    {
        $this->voltage = $voltage;
    }

    public function getRown(): ?string
    {
        return $this->rown;
    }

    public function setRown(?string $rown): void
    {
        $this->rown = $rown;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(?string $engine): void
    {
        $this->engine = $engine;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(?string $power): void
    {
        $this->power = $power;
    }

    public function getMixtures(): ?string
    {
        return $this->mixtures;
    }

    public function setMixtures(?string $mixtures): void
    {
        $this->mixtures = $mixtures;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): void
    {
        $this->time = $time;
    }

    public function getDrive(): ?string
    {
        return $this->drive;
    }

    public function setDrive(?string $drive): void
    {
        $this->drive = $drive;
    }

    public function getRetainer(): ?string
    {
        return $this->retainer;
    }

    public function setRetainer(?string $retainer): void
    {
        $this->retainer = $retainer;
    }

    public function getConnections(): ?string
    {
        return $this->connections;
    }

    public function setConnections(?string $connections): void
    {
        $this->connections = $connections;
    }

    public function getWheels(): ?string
    {
        return $this->wheels;
    }

    public function setWheels(?string $wheels): void
    {
        $this->wheels = $wheels;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getMotherland(): ?string
    {
        return $this->motherland;
    }

    public function setMotherland(?string $motherland): void
    {
        $this->motherland = $motherland;
    }

    public function getIdProductType(): ?string
    {
        return $this->idProductType;
    }

    public function setIdProductType(?string $idProductType): void
    {
        $this->idProductType = $idProductType;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

}
