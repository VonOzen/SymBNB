<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'startDate',
                DateType::class,
                $this->getAttributes("Day of arrival", "Choose an arrival day", [
                    "widget" => "single_text"
                ])
            )
            ->add(
                'endDate',
                DateType::class,
                $this->getAttributes("Day of departure", "Choose a departure day", [
                    "widget" => "single_text"
                ])
            )
            ->add(
                'comment',
                TextareaType::class,
                $this->getAttributes(false, "Write a comment to your host if needed")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
