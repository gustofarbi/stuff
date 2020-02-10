<?php


namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Index;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @Document()
 */
class ApiToken
{
    /**
     * @Id()
     * @var string
     */
    private $id;

    /**
     * @Field(type="string")
     * @Index()
     */
    private string $content;

    /**
     * @Field(type="date")
     */
    private DateTime $expiresAt;

    /**
     * @ReferenceOne(targetDocument="User::class", inversedBy="apiTokens")
     */
    private User $user;

    public function __construct(User $user, string $content)
    {
        $this->user      = $user;
        $this->content   = $content;
        $this->expiresAt = new DateTime('+1 day');
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}