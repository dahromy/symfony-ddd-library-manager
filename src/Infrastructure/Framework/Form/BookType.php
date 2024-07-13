<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter book title'],
                'label_attr' => ['class' => 'sr-only'],
            ])
            ->add('isbn', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter ISBN'],
                'label_attr' => ['class' => 'sr-only'],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'sr-only'],
                'placeholder' => 'Select an author',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
