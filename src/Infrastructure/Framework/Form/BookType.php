<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Book;
use App\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookType extends AbstractType
{
    private $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('isbn', TextType::class)
            ->add('author', EntityType::class, [
                'class' => 'App\Domain\Entity\Author',
                'choice_label' => 'name',
                'query_builder' => function (AuthorRepositoryInterface $ar) {
                    return $ar->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
