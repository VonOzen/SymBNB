<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
  /**
     * Change input label and placeholder
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    protected function getAttributes($label, $placeholder, $options = [])
    {
      return array_merge([
          'label' => $label,
          'attr' => [
              'placeholder' => $placeholder
          ]
          ], $options)
      ;
    }
}