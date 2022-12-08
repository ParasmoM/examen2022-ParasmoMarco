<?php

namespace App\Entity;

use App\Repository\ChansonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChansonRepository::class)]
class Chanson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAlbum = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paroles = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column]
    private ?int $votes = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\ManyToOne(inversedBy: 'chansons')]
    private ?Genre $genre = null;

    #[ORM\Column(nullable: true)]
    private ?int $genre_id = null;

    public function __construct() {
        $this->votes = 0;
        $this->dateAjout = new \DateTime;
    }
    public function __toString() {
        return $this->auteur;
    }
    public function increaseVotes() {
        return ++$this->votes;
    }
    public function decreaseVotes() {
        return --$this->votes;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNomAlbum(): ?string
    {
        return $this->nomAlbum;
    }

    public function setNomAlbum(string $nomAlbum): self
    {
        $this->nomAlbum = $nomAlbum;

        return $this;
    }

    public function getParoles(): ?string
    {
        return $this->paroles;
    }

    public function setParoles(string $paroles): self
    {
        $this->paroles = $paroles;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getGenreId(): ?int
    {
        return $this->genre_id;
    }

    public function setGenreId(?int $genre_id): self
    {
        $this->genre_id = $genre_id;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
