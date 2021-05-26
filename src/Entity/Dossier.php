<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
 */
class Dossier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $ordonnance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrdonnance(): ?string
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(string $ordonnance): self
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }
}
