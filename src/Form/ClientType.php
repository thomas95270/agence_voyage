<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('roles', ChoiceType::class, [
            'multiple' => true,
            'expanded' => true,
            'choices' => [
                "ROLE_ADMIN" => "ROLE_ADMIN",
                "ROLE_CLIENT" => "ROLE_CLIENT",
                "ROLE_CONSEILLER" => "ROLE_CONSEILLER"
            ],

        ])
        ->add('adresse', TextType::class)
        ->add('ville', TextType::class)
        ->add('cp', IntegerType::class)
        ->add('tel', TextType::class)
        ->add('email', EmailType::class)
        ->add('password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}