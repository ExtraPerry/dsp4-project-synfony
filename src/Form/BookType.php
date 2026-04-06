<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['placeholder' => 'Book title'],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 5, 'placeholder' => 'Book description'],
            ])
            ->add('isbn', TextType::class, [
                'required' => false,
                'label' => 'ISBN',
                'attr' => ['placeholder' => 'ISBN (10 or 13 digits)'],
            ])
            ->add('publicationDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Publication Date',
            ])
            ->add('pageCount', IntegerType::class, [
                'required' => false,
                'label' => 'Page Count',
            ])
            ->add('coverImage', TextType::class, [
                'required' => false,
                'label' => 'Cover Image URL',
                'attr' => ['placeholder' => 'https://example.com/image.jpg'],
            ])
            ->add('stockQuantity', IntegerType::class, [
                'label' => 'Stock Quantity',
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Select a language',
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
