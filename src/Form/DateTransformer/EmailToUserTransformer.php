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
    private $finderCallback;

    public function __construct(UserRepository $userRepository, callable $finderCallback)
    {
        $this->userRepository = $userRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof User) {
            throw new LogicException('The UserSelectTextType only be used with User Objects');
        }

        return $value->getEmail();
    }

    /**
     * @param mixed $value
     * @return User|void
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }
        $callback = $this->finderCallback;
        $user = $callback($this->userRepository, $value);

        if (!$user) {
            throw new TransformationFailedException(sprintf('No user was found with email %s', $value));
        }

        return $user;
    }
}