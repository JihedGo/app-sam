<?php

namespace App\Entity;

use App\Repository\CapteurMesurementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CapteurMesurementRepository::class)
 */
class CapteurMesurement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $temperature;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getCoeur(): ?string
    {
        return $this->coeur;
    }

    public function setCoeur(string $coeur): self
    {
        $this->coeur = $coeur;

        return $this;
    }
}
