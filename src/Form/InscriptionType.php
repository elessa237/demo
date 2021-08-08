<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Ex: demo@symf.com'
                ],
                'label'=>'Email :',
            ])
            ->add('password',PasswordType::class, [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'votre mot de passe...'
            ],
            'label' => 'Mot de passe :',
            ])
            ->add('confirm_password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Confirm votre mot de passe...'
                ],
                'label' => 'Confirmer le mot de passe :',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
