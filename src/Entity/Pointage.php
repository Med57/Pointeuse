<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PointageRepository;

/**
 * @ORM\Entity(repositoryClass=PointageRepository::class)
 */
class Pointage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $jour;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $poste;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $arrive;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $arrivepointage;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $depart;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $departpointage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heuresup;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getArrive(): ?\DateTimeInterface
    {
        return $this->arrive;
    }

    public function setArrive(?\DateTimeInterface $arrive): self
    {
        $this->arrive = $arrive;

        return $this;
    }

    public function getArrivepointage(): ?\DateTimeInterface
    {
        return $this->arrivepointage;
    }

    public function setArrivepointage(?\DateTimeInterface $arrivepointage): self
    {
        $this->arrivepointage = $arrivepointage;

        return $this;
    }

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(?\DateTimeInterface $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDepartpointage(): ?\DateTimeInterface
    {
        return $this->departpointage;
    }

    public function setDepartpointage(?\DateTimeInterface $departpointage): self
    {
        $this->departpointage = $departpointage;

        return $this;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(?int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getHeuresup(): ?int
    {
        return $this->heuresup;
    }

    public function setHeuresup(?int $heuresup): self
    {
        $this->heuresup = $heuresup;

        return $this;
    }


}
