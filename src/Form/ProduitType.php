<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Produit;
use App\Form\EtapeType;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['edit'] == true){

            $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('photoFile', VichImageType::class, [
                'label' => 'Photo',
                'required' =>false,
                'allow_delete' =>false,
                'download_uri' =>false,
                'image_uri' =>false
                ])
            ->add('prix', IntegerType::class)
            ->add('destinations', EntityType::class, [
                'class' => Destination::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'titre'
                ])
            ->add('etapes', CollectionType::class, [
                'entry_type' => EtapeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                ])
            ;
        } else{
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('photoFile', VichImageType::class, [
                'label' => 'Photo'
            ])
            ->add('prix', IntegerType::class)
            ->add('destinations', EntityType::class, [
                'class' => Destination::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'titre'
                ])
            ->add('etapes', CollectionType::class, [
                'entry_type' => EtapeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                ])
        ;}
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'edit' => false
        ]);
    }
}
