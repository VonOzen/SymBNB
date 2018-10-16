<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{

    /**
     * Change input label and placeholder
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getAttributes($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title', 
                TextType::class, 
                $this->getAttributes("Title", "Title of your awesome ad")
            )
            ->add(
                'introduction', 
                TextType::class, 
                $this->getAttributes("Introduction", "Introduction text for your magnificent ad")
            )
            ->add(
                'content', 
                TextareaType::class, $this->getAttributes("Content", "Content of your sublime ad")
            )
            ->add(
                'price', 
                MoneyType::class, 
                $this->getAttributes("Price per night", "Price for your amazing place per night")
            )
            ->add(
                'rooms', 
                IntegerType::class, 
                $this->getAttributes("Number of rooms", "Available ultra comfy rooms")
            )
            ->add(
                'coverImage', 
                UrlType::class, 
                $this->getAttributes("URL of the image", "URL to your breathtaking image")
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
