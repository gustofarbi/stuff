<?php

namespace App\Document;

use App\Traits\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Doctrine\ODM\MongoDB\Mapping\Annotations\UniqueIndex;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Document(collection="users")
 */
class User implements UserInterface
{
    use DateTrait;

    /**
     * @Id
     */
    private $id;

    /**
     * @Field(type="string")
     * @UniqueIndex(order="asc")
     */
    private string $email = '';

    /**
     * @Field(type="string")
     */
    private string $username = '';

    /**
     * @Field(type="collection")
     */
    private array $roles = [];

    /**
     * @Field(type="string")
     */
    private string $password = '';

    /**
     * @var Comment[]
     * @ReferenceMany(targetDocument="Comment::class", mappedBy="user")
     */
    private $comments;

    /**
     * @var BlogPost[]
     * @ReferenceMany(targetDocument="BlogPost::class", mappedBy="user")
     */
    private $blogposts;

    /**
     * @var ApiToken[]
     * @ReferenceMany(targetDocument="ApiToken::class", mappedBy="user", cascade={"persist", "remove"},
     *                                                      orphanRemoval=true)
     */
    private $apiTokens;

    public function __construct()
    {
        $this->apiTokens = new ArrayCollection();
        $this->blogposts = new ArrayCollection();
        $this->comments = new ArrayCollection();

        $this->setCreatedAt()
             ->setUpdatedAt();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return (string)$this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getBlogposts(): Collection
    {
        return $this->blogposts;
    }

    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials(): void
    {
        $this->apiTokens->clear();
    }
}
