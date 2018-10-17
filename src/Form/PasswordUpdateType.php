<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                $this->getAttributes("Current password", "Enter your current password")
            )
            ->add(
                'newPassword',
                PasswordType::class,
                $this->getAttributes("New password", "Enter your new password")
            )
            ->add(
                'confirmPassword',
                PasswordType::class,
                $this->getAttributes("Confirm new password", "Please confirm your new password")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
