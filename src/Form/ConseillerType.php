<?php

namespace App\Form;

use App\Entity\Conseiller;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConseillerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['edit'] == true){
            $builder
                ->add('email', EmailType::class)
                ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => [
                        "Conseiller" => "ROLE_CONSEILLER",
                        "Administrateur" => "ROLE_ADMIN",
                    ],
                ])
                ->add('prenom', TextType::class)
                ->add('nom', TextType::class)
                ->add('photoFile', VichImageType::class, [
                    'required' =>false,
                    'allow_delete' =>false,
                    'download_uri' =>false,
                    'image_uri' =>false
                    ])
                ->add('referent', ChoiceType::class,[
                    'choices' => [
                        'oui' => true,
                        'non' => false
                    ],
                    'multiple' => false,
                    'expanded' => true,
                    ])
                ->add('description', TextareaType::class)
                ->add('specialite', EntityType::class, [
                    'class' => Destination::class,
                    'choice_label' => 'titre'
                    ]
                )
            ;
        } else{
            $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    "Conseiller" => "ROLE_CONSEILLER",
                    "Administrateur" => "ROLE_ADMIN",
                ],
            ])
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('photoFile', VichImageType::class)
            ->add('referent', ChoiceType::class,[
                'choices' => [
                    'non référent' => false,
                    'référent' => true,
                    ],
                'multiple' => false,
                'expanded' => true,
                ]
            )
            ->add('description', TextareaType::class)
            ->add('specialite', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'titre'
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conseiller::class,
            'edit' => false
        ]);
    }
}
