<?php

namespace App\Entity;

use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PublisherRepository::class)
 * @ApiResource(
 *   normalizationContext={"groups"={"publisher:read"}}
 * )
 */
class Publisher {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups({"publisher:read", "book:read"})
   *
   */
  private $name;

  /**
   * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="publishers")
   */
  private $books;

  public function __construct() {
    $this->books = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }

  /**
   * @return Collection|Book[]
   */
  public function getBooks(): Collection {
    return $this->books;
  }

  public function addBook(Book $book): self {
    if (!$this->books->contains($book)) {
      $this->books[] = $book;
      $book->addPublisher($this);
    }

    return $this;
  }

  public function removeBook(Book $book): self {
    if ($this->books->removeElement($book)) {
      $book->removePublisher($this);
    }

    return $this;
  }

  public function __toString(){
    return $this->getName();
  }
}
