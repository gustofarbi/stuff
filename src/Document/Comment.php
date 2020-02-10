<?php

namespace App\Document;

use App\Traits\DateTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="comments")
 */
class Comment
{
    use DateTrait;

    /**
     * @ODM\Id
     * @var string
     */
    protected $id;

    /**
     * @ODM\ReferenceOne(targetDocument=User::class, inversedBy="comments")
     */
    protected User $user;

    /**
     * @ODM\ReferenceOne(targetDocument="BlogPost::class")
     */
    private BlogPost $blog;

    /**
     * @ODM\Field(type="string")
     */
    protected string $content;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getBlog(): BlogPost
    {
        return $this->blog;
    }

    public function setBlog(BlogPost $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}