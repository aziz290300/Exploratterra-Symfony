<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Your Name',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your Email',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Your Phone',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('objet', TextareaType::class, [
                'label' => 'Your Object',
                'attr' => ['class' => 'form-control', 'rows' => '4'],
            ])
            ->add('contenuReclamation', TextareaType::class, [
                'label' => 'Your Message',
                'attr' => ['class' => 'form-control', 'rows' => '6'],
            ])
            ->add('typeReclamation', null, [
                'label' => 'Type of Reclamation',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
