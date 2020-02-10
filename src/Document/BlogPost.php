<?php

namespace App\Document;

use App\Traits\DateTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\PersistentCollection;

/**
 * @ODM\Document(collection="blogposts")
 */
class BlogPost
{
    use DateTrait;

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected string $name = '';

    /**
     * @var User
     * @ODM\ReferenceOne(targetDocument="User::class", inversedBy="blogposts")
     */
    private User $user;

    /**
     * @var Comment[]
     * @ODM\ReferenceMany(targetDocument="Comment::class")
     */
    private $comments;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->setUpdatedAt()->setCreatedAt();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments[] = $comment;

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}