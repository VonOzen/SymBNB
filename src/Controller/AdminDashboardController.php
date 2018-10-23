<?php

namespace App\Controller;

use App\Service\Stats;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * 
     * @param ObjectManager $manager
     * @return Response
     */
    public function dashboard(ObjectManager $manager, Stats $stats)
    {
        return $this->render('admin/dashboard/dashboard.html.twig', [
            'stats'    => $stats->getStats(),
            'bestAds'  => $stats->getAdsStats('DESC'),
            'worstAds' => $stats->getAdsStats('ASC')
        ]);
    }
}
