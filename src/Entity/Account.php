<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AccountRepository::class)]

#[UniqueEntity(
    fields: [
        'name'
    ]
)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'eventAccount')]
    private Collection $vehicles;

    #[ORM\OneToMany(targetEntity: EventVehicle::class, mappedBy: 'account')]
    private Collection $eventVehicles;

    #[ORM\OneToMany(targetEntity: RecordFile::class, mappedBy: 'businessAccount')]
    private Collection $recordFiles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->eventVehicles = new ArrayCollection();
        $this->recordFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setEventAccount($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getEventAccount() === $this) {
                $vehicle->setEventAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventVehicle>
     */
    public function getEventVehicles(): Collection
    {
        return $this->eventVehicles;
    }

    public function addEventVehicle(EventVehicle $eventVehicle): static
    {
        if (!$this->eventVehicles->contains($eventVehicle)) {
            $this->eventVehicles->add($eventVehicle);
            $eventVehicle->setAccount($this);
        }

        return $this;
    }

    public function removeEventVehicle(EventVehicle $eventVehicle): static
    {
        if ($this->eventVehicles->removeElement($eventVehicle)) {
            // set the owning side to null (unless already changed)
            if ($eventVehicle->getAccount() === $this) {
                $eventVehicle->setAccount(null);
            }
        }

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
            $recordFile->setBusinessAccount($this);
        }

        return $this;
    }

    public function removeRecordFile(RecordFile $recordFile): static
    {
        if ($this->recordFiles->removeElement($recordFile)) {
            // set the owning side to null (unless already changed)
            if ($recordFile->getBusinessAccount() === $this) {
                $recordFile->setBusinessAccount(null);
            }
        }

        return $this;
    }
}
