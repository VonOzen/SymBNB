<?php

namespace App\Controller;

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
    public function dashboard(ObjectManager $manager)
    {
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $ads = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();
        $bookings = $manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
        $comments = $manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();

        $bestAds = $manager->createQuery(
            'SELECT AVG(c.rating) as rating, a.title, a.id, u.firstName, u.lastName, u.avatar 
            FROM App\Entity\Comment c 
            JOIN c.ad a 
            JOIN a.author u 
            GROUP BY a
            ORDER BY rating DESC'
        )->setMaxResults(5)->getResult();

        $worstAds = $manager->createQuery(
            'SELECT AVG(c.rating) as rating, a.title, a.id, u.firstName, u.lastName, u.avatar 
            FROM App\Entity\Comment c 
            JOIN c.ad a 
            JOIN a.author u 
            GROUP BY a
            ORDER BY rating ASC'
        )->setMaxResults(5)->getResult();

        dump($bestAds);

        return $this->render('admin/dashboard/dashboard.html.twig', [
            'stats'    => compact('users','ads','bookings','comments'),
            'bestAds'  => $bestAds,
            'worstAds' => $worstAds
        ]);
    }
}
