<?php


namespace App\Traits;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait DateTrait
{
    /**
     * @ODM\Field(type="date")
     */
    protected DateTime $createdAt;

    /**
     * @ODM\Field(type="date")
     */
    protected DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt = null): self
    {
        if ($createdAt === null) {
            $createdAt = new DateTime();
        }

        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt = null): self
    {
        if ($updatedAt === null) {
            $updatedAt = new DateTime();
        }

        $this->updatedAt = $updatedAt;

        return $this;
    }
}