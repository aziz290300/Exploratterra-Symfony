<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomVol')
            ->add('startDate', DateTimeType::class, [
                'label' => 'Booking Date and Time',
                'widget' => 'single_text', // Renders the input as a single text box
                'format' => 'yyyy-MM-dd HH:mm:ss', // Adjust the format based on your needs
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'], // Add a class for JavaScript initialization
            ])
            ->add('image', FileType::class, [
                'label' => 'Hotel Image',
                'required' => false, // Allow the field to be empty
                'mapped' => false,   // This field is not mapped to an entity property
            ])
            ->add('nombre')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
