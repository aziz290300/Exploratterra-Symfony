<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom Evenement',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateDebut', null, [
                'label' => 'Date Debut',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('lieu', null, [
                'label' => 'Lieu',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control-file'],
            ])
            ->add('tarif', null, [
                'label' => 'Tarif',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('placesDispo', null, [
                'label' => 'Places Disponible',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
