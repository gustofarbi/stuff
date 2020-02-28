<?php

namespace App\Document;

use App\Traits\DateTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="comments", repositoryClass="CommentRepository::class")
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
     * @ODM\ReferenceOne(targetDocument="User::class", inversedBy="comments")
     */
    protected User $user;

    /**
     * @ODM\ReferenceOne(targetDocument="BlogPost::class")
     */
    private BlogPost $blogPost;

    /**
     * @ODM\Field(type="string")
     */
    protected string $content;

    public function __construct(User $user, BlogPost $blogPost, string $content)
    {
        $this->user = $user;
        $this->blogPost = $blogPost;
        $this->content = $content;

        $this->setUpdatedAt()
            ->setCreatedAt();
    }

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

    public function getBlogPost(): BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(BlogPost $blogPost): self
    {
        $this->blogPost = $blogPost;

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
