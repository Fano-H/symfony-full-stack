<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]

#[UniqueEntity(
    fields: [
        'vin',
        'registrationNo',
    ]
)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationNo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfCirculation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mileAge = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Energy $energy = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?EventOrigin $originEvent = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Account $eventAccount = null;

    #[ORM\OneToMany(targetEntity: RecordFile::class, mappedBy: 'vehicle')]
    private Collection $recordFiles;

    public function __construct()
    {
        $this->recordFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): static
    {
        $this->vin = $vin;

        return $this;
    }

    public function getRegistrationNo(): ?string
    {
        return $this->registrationNo;
    }

    public function setRegistrationNo(?string $registrationNo): static
    {
        $this->registrationNo = $registrationNo;

        return $this;
    }

    public function getDateOfCirculation(): ?\DateTimeInterface
    {
        return $this->dateOfCirculation;
    }

    public function setDateOfCirculation(?\DateTimeInterface $dateOfCirculation): static
    {
        $this->dateOfCirculation = $dateOfCirculation;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getMileAge(): ?string
    {
        return $this->mileAge;
    }

    public function setMileAge(?string $mileAge): static
    {
        $this->mileAge = $mileAge;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getOriginEvent(): ?EventOrigin
    {
        return $this->originEvent;
    }

    public function setOriginEvent(?EventOrigin $originEvent): static
    {
        $this->originEvent = $originEvent;

        return $this;
    }

    public function getEventAccount(): ?Account
    {
        return $this->eventAccount;
    }

    public function setEventAccount(?Account $eventAccount): static
    {
        $this->eventAccount = $eventAccount;

        return $this;
    }

    /**
     * @return Collection<int, RecordFile>
     */
    public function getRecordFiles(): Collection
    {
        return $this->recordFiles;
    }

    public function addRecordFile(RecordFile $recordFile): static
    {
        if (!$this->recordFiles->contains($recordFile)) {
            $this->recordFiles->add($recordFile);
            $recordFile->setVehicle($this);
        }

        return $this;
    }

    public function removeRecordFile(RecordFile $recordFile): static
    {
        if ($this->recordFiles->removeElement($recordFile)) {
            // set the owning side to null (unless already changed)
            if ($recordFile->getVehicle() === $this) {
                $recordFile->setVehicle(null);
            }
        }

        return $this;
    }

}
