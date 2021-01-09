<?php
declare(strict_types=1);

namespace App\Form\DateTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use LogicException;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function transform($value)
    {
        if(null === $value){
            return '';
        }

        if(!$value instanceof User){
            throw new LogicException('The UserSelectTextType only be used with User Objects');
        }

        return $value->getEmail();
    }

    public function reverseTransform($value)
    {
        $user = $this->userRepository->findOneBy(['email' => $value]);

       if(!$user){
           throw new TransformationFailedException(sprintf('No user was found with email %s', $value));
       }

       return $user;
    }
}