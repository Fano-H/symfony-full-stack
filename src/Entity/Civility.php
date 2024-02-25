<?php

namespace App\Entity;

use App\Repository\CivilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CivilityRepository::class)]
class Civility
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: RecordFile::class, mappedBy: 'civility')]
    private Collection $recordFiles;

    public function __construct()
    {
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
            $recordFile->setCivility($this);
        }

        return $this;
    }

    public function removeRecordFile(RecordFile $recordFile): static
    {
        if ($this->recordFiles->removeElement($recordFile)) {
            // set the owning side to null (unless already changed)
            if ($recordFile->getCivility() === $this) {
                $recordFile->setCivility(null);
            }
        }

        return $this;
    }
}
