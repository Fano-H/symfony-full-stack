<?php

namespace App\Entity;

use App\Repository\SaleTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleTypeRepository::class)]
class SaleType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(targetEntity: RecordFile::class, mappedBy: 'saleType')]
    private Collection $recordFiles;

    public function __construct()
    {
        $this->recordFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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
            $recordFile->setSaleType($this);
        }

        return $this;
    }

    public function removeRecordFile(RecordFile $recordFile): static
    {
        if ($this->recordFiles->removeElement($recordFile)) {
            // set the owning side to null (unless already changed)
            if ($recordFile->getSaleType() === $this) {
                $recordFile->setSaleType(null);
            }
        }

        return $this;
    }
}
