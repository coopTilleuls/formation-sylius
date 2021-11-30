<?php

namespace App\Form\Type\Admin;

use App\Entity\Cms\Page;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Publié' => 'published',
                    'En cours de validation' => 'validation',
                ]
            ])
            ->add('content', CKEditorType::class)
            ->add('product', ProductAutocompleteChoiceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Page::class,
            ])
        ;
    }
}
