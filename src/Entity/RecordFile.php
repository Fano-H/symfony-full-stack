<?php

namespace App\Entity;

use App\Repository\RecordFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecordFileRepository::class)]
class RecordFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $recordNo = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?Civility $civility = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $trackNumberName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionalAddress1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $homePhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cellPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jobPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?Vehicle $vehicle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currentVehicleOwner = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?City $city = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?Seller $seller = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?SaleType $saleType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invoicingComment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $saleFolderNo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $saleIntermediary = null;

    #[ORM\ManyToOne(inversedBy: 'recordFiles')]
    private ?ProspectType $prospectType = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecordNo(): ?string
    {
        return $this->recordNo;
    }

    public function setRecordNo(string $recordNo): static
    {
        $this->recordNo = $recordNo;

        return $this;
    }

    public function getCivility(): ?Civility
    {
        return $this->civility;
    }

    public function setCivility(?Civility $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getTrackNumberName(): ?string
    {
        return $this->trackNumberName;
    }

    public function setTrackNumberName(?string $trackNumberName): static
    {
        $this->trackNumberName = $trackNumberName;

        return $this;
    }

    public function getAdditionalAddress1(): ?string
    {
        return $this->additionalAddress1;
    }

    public function setAdditionalAddress1(?string $additionalAddress1): static
    {
        $this->additionalAddress1 = $additionalAddress1;

        return $this;
    }

    public function getHomePhone(): ?string
    {
        return $this->homePhone;
    }

    public function setHomePhone(?string $homePhone): static
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    public function setCellPhone(?string $cellPhone): static
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    public function getJobPhone(): ?string
    {
        return $this->jobPhone;
    }

    public function setJobPhone(?string $jobPhone): static
    {
        $this->jobPhone = $jobPhone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getCurrentVehicleOwner(): ?string
    {
        return $this->currentVehicleOwner;
    }

    public function setCurrentVehicleOwner(?string $currentVehicleOwner): static
    {
        $this->currentVehicleOwner = $currentVehicleOwner;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(?Seller $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function getSaleType(): ?SaleType
    {
        return $this->saleType;
    }

    public function setSaleType(?SaleType $saleType): static
    {
        $this->saleType = $saleType;

        return $this;
    }

    public function getInvoicingComment(): ?string
    {
        return $this->invoicingComment;
    }

    public function setInvoicingComment(?string $invoicingComment): static
    {
        $this->invoicingComment = $invoicingComment;

        return $this;
    }

    public function getSaleFolderNo(): ?string
    {
        return $this->saleFolderNo;
    }

    public function setSaleFolderNo(?string $saleFolderNo): static
    {
        $this->saleFolderNo = $saleFolderNo;

        return $this;
    }

    public function getSaleIntermediary(): ?string
    {
        return $this->saleIntermediary;
    }

    public function setSaleIntermediary(?string $saleIntermediary): static
    {
        $this->saleIntermediary = $saleIntermediary;

        return $this;
    }

    public function getProspectType(): ?ProspectType
    {
        return $this->prospectType;
    }

    public function setProspectType(?ProspectType $prospectType): static
    {
        $this->prospectType = $prospectType;

        return $this;
    }

}
