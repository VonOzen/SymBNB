<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getAttributes("Firstname", "Enter your firstname")
            )
            ->add(
                'lastName',
                TextType::class,
                $this->getAttributes("Lastname", "Enter your lastname")
            )
            ->add(
                'email',
                EmailType::class,
                $this->getAttributes("Email", "Enter your email address")
            )
            ->add(
                'avatar',
                UrlType::class,
                $this->getAttributes("Avatar", "URL to your avatar")
            )
            ->add(
                'hash',
                PasswordType::class,
                $this->getAttributes("Password", "Choose your password")
            )
            ->add(
                'introduction',
                TextType::class,
                $this->getAttributes("Introduction", "Introduce yourself in few words :D")
            )
            ->add(
                'description',
                TextareaType::class,
                $this->getAttributes("Description", "Describe yourself, time to shine")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
