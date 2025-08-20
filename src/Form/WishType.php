<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title :',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'placeholder' => '----- Choose Category -----',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Your name :',
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Is Published :',
                'required' => false,
                'attr' => [
                    'checked' => true,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add Wish',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
