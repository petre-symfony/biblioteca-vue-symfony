<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ApiResource(
 *   normalizationContext={"groups"={"book:read"}},
 *   attributes={"pagination_items_per_page"=10}
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *   "authors": "exact"
 * })
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
   * @Groups("book:read")
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   * @Groups({"book:read"})
   */
  private $location;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   * @Groups({"book:read"})
   */
  private $subject;

  /**
   * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
   * @Groups({"book:read"})
   */
  private $authors;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Groups({"book:read"})
   */
  private $volume;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   * @Groups({"book:read"})
   */
  private $other;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Groups({"book:read"})
   */
  private $firstPublishedYear;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Groups({"book:read"})
   */
  private $bookPublishedYear;

  /**
   * @ORM\Column(type="string", length=30, nullable=true)
   * @Groups({"book:read"})
   */
  private $ISBN;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   * @Groups({"book:read"})
   */
  private $complete;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "NONE"})
   * @Groups({"book:read"})
   */
  private $missingPages;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Groups({"book:read"})
   */
  private $pages;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, options={"default": "romana"})
   * @Groups({"book:read"})
   */
  private $language;

  /**
   * @ORM\Column(type="string", length=20, nullable=true)
   * @Groups({"book:read"})
   */
  private $format;

  /**
   * @ORM\Column(type="text", nullable=true)
   * @Groups({"book:read"})
   */
  private $content;

  /**
   * @ORM\ManyToMany(targetEntity=Publisher::class, inversedBy="books")
   * @Groups({"book:read"})
   */
  private $publishers;

  /**
   * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="books")
   * @Groups({"book:read"})
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