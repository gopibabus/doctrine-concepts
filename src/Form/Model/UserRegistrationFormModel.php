<?php

namespace App\Form\Model;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"}, message="This email is already registered")
 */
class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please eneter an email")
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Choose Password")
     * @Assert\Length(min=5, minMessage="Please choose right length for your password")
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="You should agree to all our terms first!!!")
     */
    public $agreeTerms;
}