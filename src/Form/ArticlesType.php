<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur', null, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Auteur :',
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'height:150px'
                ],
                'label' => 'Contenu :',
            ])
            ->add('imageFile', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'aucune image choisie'
                ],
                'label' => 'Image :',
            ])
            ->add(
                'categorie',
                null,
                [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Categories :',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
