<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 * @ApiResource(
 *   normalizationContext={
 *     "groups"={"subCategory:read"}
 *   }
 * )
 */
class SubCategory {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups({"subCategory:read", "book:read"})
   */
  private $name;

  /**
   * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
   * @Groups({"subCategory:read"})
   */
  private $type;

  /**
   * @ORM\OneToMany(targetEntity=Book::class, mappedBy="genre")
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

  public function getType(): ?Category {
    return $this->type;
  }

  public function setType(?Category $type): self {
    $this->type = $type;

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
      $book->setGenre($this);
    }

    return $this;
  }

  public function removeBook(Book $book): self {
    if ($this->books->removeElement($book)) {
      // set the owning side to null (unless already changed)
      if ($book->getGenre() === $this) {
        $book->setGenre(null);
      }
    }

    return $this;
  }

  public function __toString(){
    return $this->getName();
  }
}
