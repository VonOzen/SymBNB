<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface
{
  /**
   * Transform a Datetime into a string (french format dd/mm/yyyy)
   *
   * @param Datetime $date
   * @return String $date
   */
  public function transform($date) {

    if($date === null) {
      return '';
    }

    return $date->format('d/m/Y');
  }

  /**
   * Transform a french date (string) into Datetime
   *
   * @param String $frenchDate
   * @return Datetime $date
   */
  public function reverseTransform($frenchDate) {

    if($frenchDate === null) {
      throw new TransformationFailedException("Please enter a date.");
    }

    $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

    if($date === false) {
      throw new TransformationFailedException("Date format is not valid.");
    }

    return $date;

  }
}

