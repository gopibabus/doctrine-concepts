<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Article $article */
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        # https://symfony.com/doc/current/reference/forms/types.html
        $builder->add('title', TextType::class, [
            'help' => 'Enter title of the post'
        ])
            ->add('content', null, [
                /** This is custom attribute(rows) that we set in TextAreaSizeExtension */
                'rows' => 15
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user){
                    return sprintf('(%d) %s', $user->getId(), $user->getEmail());
                },
                'placeholder' => 'Choose an Author',
                'choices' => $this->userRepository->findAllEmailAlphabetical(),
                'invalid_message' => 'Please Select valid Author to proceed..'
            ])
            # We are overriding above field with our custom field type
            ->add('author', UserSelectTextType::class, [
                'disabled' => $isEdit
            ]);

        if($options['include_published_at']){
            $builder->add('publishedAt', DateType::class, [
                'help' => 'Select date to be published'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'include_published_at' => false
        ]);
    }
}