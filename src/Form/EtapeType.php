<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['edit'] == true){
            $builder
            ->add('titre')
            ->add('description')
            ->add('hotel')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'titre'
                ])
            ->add('photoFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false
            ]);
        }else{
        $builder
            ->add('titre')
            ->add('description')
            ->add('hotel')
            ->add('photoFile', VichImageType::class)
        ;}
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
            'edit' => false
        ]);
    }
}
