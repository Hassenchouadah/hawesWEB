<?php

namespace App\Form;

use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            


            ->add('nom',ChoiceType::class, [
                'choices' => [
                    "choisir type de l'hebergement " =>NULL,
                    'Hotel' => 'hotel',
                    'Maison dhote' => 'maison dhote',
                ]
                
                ]
            )
            ->add('city',TextType::class,[
                'attr'=> [
                    'placeholder'=>"saisir le ville"
                ]
                
                ]
                )
            ->add('dateAjout')
            ->add('adress',TextType::class,[
                'attr'=> [
                    'placeholder'=>"saisir l'adress"
                ]
            ]
            )
            ->add('nomHotel',TextType::class,[
                'attr'=> [
                    'placeholder'=>"saisir le nom de l'hotel"
                ]
            ]
            )
            ->add('nbChambres',IntegerType::class,[
                
                'attr'=> [
                    'placeholder'=>"saisir le nombre de chambre"
                ]
            ]
            )
            ->add('nbSuites',IntegerType::class,[
                'attr'=> [
                    'placeholder'=>"saisir le nombre de suite"
                ]
            ]
            )
            ->add('piscine', ChoiceType::class, [
                'choices' => [
                    "selectioner" =>NULL,
                    'avec piscine' => 1,
                    'pas de piscine' => 0,
                ]
                
            ])
            
            ->add('imagee', FileType::class, [
                'mapped' => false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=>"choisir une image"
                ]
                
            ])
            ->add('prix',IntegerType::class,[
                'attr'=> [
                    'placeholder'=>"saisir le prix de l'hotel"
                ]
            ]
            )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
