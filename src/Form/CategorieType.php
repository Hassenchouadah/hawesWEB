<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etoile')
            ->add('idHbg',EntityType::class,[
                'class'     =>Hebergement::class,
                'label'     =>'Nom',
                'mapped'    =>false,
                'choice_label' => function($choice){
                    
                    return $choice->getNomHotel();

                }
            ] )
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
