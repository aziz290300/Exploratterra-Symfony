<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom')
        ->add('prenom')
        ->add('numero_de_CIN')
        ->add('Voyage')
        ->add('date_debut')
        ->add('date_fin')
        ->add('salaire')
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer', // Texte affiché sur le bouton
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
