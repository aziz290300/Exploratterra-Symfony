<?php

// src/Form/BookingType.php
namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class BookingType extends AbstractType
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
            ->add('startDate', DateTimeType::class, [
                'label' => 'Start Date',
                'widget' => 'single_text', // Use 'single_text' for HTML5 input
                'html5' => false,
            ])
            ->add('finishDate', DateTimeType::class, [
                'label' => 'Finish Date',
                'widget' => 'single_text', // Use 'single_text' for HTML5 input
                'html5' => false,
            ])
            ->add('nombre')
            ->add('save', SubmitType::class, [
                'label' => 'Book Now',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}

