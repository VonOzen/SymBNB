<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller 
{
  /**
   * Go to homepage function
   * 
   * @Route("/", name="homepage")
   * 
   * @param AdRepository $repo
   * @return Response
   */
  public function home(AdRepository $adRepo, UserRepository $userRepo)
  {
    return $this->render('default/home.html.twig', [
      'ads'   => $adRepo->findBestAds(3),
      'users' => $userRepo->findBestUsers()
    ]);
  }
}