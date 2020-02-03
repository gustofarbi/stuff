<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;

/**
 * @MongoDb\Document
 */
class Product
{
    /**
     * @MongoDb\Id
     */
    protected $id;

    /**
     * @MongoDb\Field(type="string")
     */
    protected string $name;

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

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}