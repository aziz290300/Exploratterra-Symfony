<?php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('destination')
            ->add('prix')
            ->add('date_depart')
            ->add('date_retour')
            ->add('placeDisponible')
            ->add('itineraire')
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control-file'],
            ])
            ->add('guide', EntityType::class, [
                'class' => \App\Entity\Guide::class,
                'choice_label' => 'prenom',
                'placeholder' => 'Select a guide',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
