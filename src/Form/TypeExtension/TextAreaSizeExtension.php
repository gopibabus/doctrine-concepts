<?php

namespace App\Form\TypeExtension;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method iterable getExtendedTypes()
 */
class TextAreaSizeExtension implements FormTypeExtensionInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // TODO: Implement buildForm() method.
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /**
         * This attribute is added to all TextArea Field Types
         */
       $view->vars['attr']['rows'] = $options['rows'];
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        // TODO: Implement finishView() method.
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'rows' => 10
       ]);
    }

    public function getExtendedType()
    {
        return TextareaType::class;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method iterable getExtendedTypes()
    }
}