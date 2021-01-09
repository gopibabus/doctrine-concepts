<?php

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please eneter an email")
     * @Assert\Email()
     * @UniqueUser()
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