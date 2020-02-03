<?php


namespace App\Form\Model;


use App\Document\User;

class Registration
{
    protected $user;
    protected $termsAccepted;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function isTermsAccepted(): ?bool
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted): void
    {
        $this->termsAccepted = (bool)$termsAccepted;
    }


}