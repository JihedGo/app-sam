<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Patient;
/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rendezVouses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medicin;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="rendezVouses")
     */
    private $patient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTerminated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicin(): ?User
    {
        return $this->medicin;
    }

    public function setMedicin(?User $medicin): self
    {
        $this->medicin = $medicin;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getIsTerminated(): ?bool
    {
        return $this->isTerminated;
    }

    public function setIsTerminated(bool $isTerminated): self
    {
        $this->isTerminated = $isTerminated;

        return $this;
    }
}
