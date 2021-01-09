<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserSelectTextType extends \Symfony\Component\Form\AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}