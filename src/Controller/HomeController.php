<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller 
{
  /**
   * Go to homepage function
   * @Route("/", name="homepage")
   * @return void
   */
  public function homeAction()
  {
    return $this->render('DefaultPages/home.html.twig');
  }
}