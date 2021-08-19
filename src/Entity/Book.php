<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255, options={"default": "unknown"})
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $location;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $subject;

  /**
   * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
   */
  private $authors;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $volume;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $other;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $firstPublishedYear;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $bookPublishedYear;

  /**
   * @ORM\Column(type="string", length=30, nullable=true)
   */
  private $ISBN;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $complete;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "NONE"})
   */
  private $missingPages;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $pages;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "romana"})
   */
  private $language;

  /**
   * @ORM\Column(type="string", length=20, nullable=true)
   */
  private $format;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $content;

  /**
   * @ORM\ManyToMany(targetEntity=Publisher::class, inversedBy="books")
   */
  private $publishers;

  /**
   * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="books")
   */
  private $genre;

  public function __construct() {
    $this->authors = new ArrayCollection();
    $this->publishers = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(?string $name): self {
    $this->name = $name;

    return $this;
  }

  public function getLocation(): ?string {
    return $this->location;
  }

  public function setLocation(?string $location): self {
    $this->location = $location;

    return $this;
  }

  public function getSubject(): ?string {
    return $this->subject;
  }

  public function setSubject(?string $subject): self {
    $this->subject = $subject;

    return $this;
  }

  /**
   * @return Collection|Author[]
   */
  public function getAuthors(): Collection {
    return $this->authors;
  }

  public function addAuthor(Author $author): self {
    if (!$this->authors->contains($author)) {
      $this->authors[] = $author;
    }

    return $this;
  }

  public function removeAuthor(Author $author): self {
    $this->authors->removeElement($author);

    return $this;
  }

  public function getVolume(): ?int {
    return $this->volume;
  }

  public function setVolume(?int $volume): self {
    $this->volume = $volume;

    return $this;
  }

  public function getOther(): ?string {
    return $this->other;
  }

  public function setOther(?string $other): self {
    $this->other = $other;

    return $this;
  }

  public function getFirstPublishedYear(): ?int {
    return $this->firstPublishedYear;
  }

  public function setFirstPublishedYear(?int $firstPublishedYear): self {
    $this->firstPublishedYear = $firstPublishedYear;

    return $this;
  }

  public function getBookPublishedYear(): ?int {
    return $this->bookPublishedYear;
  }

  public function setBookPublishedYear(?int $bookPublishedYear): self {
    $this->bookPublishedYear = $bookPublishedYear;

    return $this;
  }

  public function getISBN(): ?string {
    return $this->ISBN;
  }

  public function setISBN(?string $ISBN): self {
    $this->ISBN = $ISBN;

    return $this;
  }

  public function getComplete(): ?bool {
    return $this->complete;
  }

  public function setComplete(?bool $complete): self {
    $this->complete = $complete;

    return $this;
  }

  public function getMissingPages(): ?string {
    return $this->missingPages;
  }

  public function setMissingPages(?string $missingPages): self {
    $this->missingPages = $missingPages;

    return $this;
  }

  public function getPages(): ?int {
    return $this->pages;
  }

  public function setPages(?int $pages): self {
    $this->pages = $pages;

    return $this;
  }

  public function getLanguage(): ?string {
    return $this->language;
  }

  public function setLanguage(?string $language): self {
    $this->language = $language;

    return $this;
  }

  public function getFormat(): ?string {
    return $this->format;
  }

  public function setFormat(?string $format): self {
    $this->format = $format;

    return $this;
  }

  public function getContent(): ?string {
    return $this->content;
  }

  public function setContent(?string $content): self {
    $this->content = $content;

    return $this;
  }

  /**
   * @return Collection|Publisher[]
   */
  public function getPublishers(): Collection {
    return $this->publishers;
  }

  public function addPublisher(Publisher $publisher): self {
    if (!$this->publishers->contains($publisher)) {
      $this->publishers[] = $publisher;
    }

    return $this;
  }

  public function removePublisher(Publisher $publisher): self {
    $this->publishers->removeElement($publisher);

    return $this;
  }

  public function getGenre(): ?SubCategory {
    return $this->genre;
  }

  public function setGenre(?SubCategory $genre): self {
    $this->genre = $genre;

    return $this;
  }


}