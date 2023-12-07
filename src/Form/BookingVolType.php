<?php

// src/Form/BookingType.php
namespace App\Form;

use App\Entity\BookingVol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class BookingVolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Add any additional fields you may have in your Booking entity
            // For example, if you have check-in and check-out date fields:
            // ->add('checkInDate', DateType::class)
            // ->add('checkOutDate', DateType::class)

            // You may also want to customize the form based on your needs
            // For example, you can add a submit button:
            
            ->add('nombre')
            ->add('save', SubmitType::class, [
                'label' => 'Book Now',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingVol::class,
        ]);
    }
}

