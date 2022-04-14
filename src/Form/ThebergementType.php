<?php

namespace App\Form;

use App\Entity\Thebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('city')
            ->add('dateAjout')
            ->add('adress')
            ->add('nomHotel')
            ->add('nbChambres')
            ->add('nbSuites')
            ->add('piscine')
            ->add('image')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Thebergement::class,
        ]);
    }
}
