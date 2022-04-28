<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = Request::createFromGlobals();
        $builder
            ->add('datepmt', HiddenType::class)
            ->add('methode', ChoiceType::class, [
                'choices' => [
                    'Chèque' => 'Chèque',
                    'Especes' => 'Especes',
                    'Virement Bancaire' => 'Virement Bancaire'
                ]])
            ->add('montant',)
            ->add('canceled', HiddenType::class)
            ->add('idres', HiddenType::class, [
                'data' => $request->request->get('idRes')
            ])
        ;
        echo $request->query->get('idRes');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }

    public function updateAction(Request $request)
    {
        // $_GET parameters
        $request->query->get('idRes');
        // $_POST parameters
        $request->request->get('idRes');
    }
}
