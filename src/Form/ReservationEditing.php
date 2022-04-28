<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationEditing extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idvol',TextType::class, [
                'required'=>true,
                'constraints'=>[new Assert\GreaterThan(0)]
            ])
            ->add('nbpersonne',TextType::class, [
                'required'=>true,
                'constraints'=>[new Assert\GreaterThan(0)],
                'attr' => array('class' => 'form-control','style' => 'margin-right:40px')
            ])
            ->add('forfait', ChoiceType::class, [
                'choices' => [
                    'Petit Déjeuner' => 'Petit Déjeuner',
                    'Demi Pension' => 'Demi Pension',
                    'Pension Compléte' => 'Pension Compléte',
                    'All-in' => 'All-in'
                ]])
            ->add('nbchambre',TextType::class, [
                'required'=>true,
                'constraints'=>[new Assert\GreaterThan(0)]
            ])
            ->add('nbsuite',TextType::class, [
                'required'=>true,
                'constraints'=>[new Assert\GreaterThan(0)]
            ])
            ->add('datearr',DateTimeType::class)
            ->add('datedep',DateTimeType::class)
            ->add('idhebr')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
