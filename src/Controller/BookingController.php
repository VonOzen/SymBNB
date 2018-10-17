<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * Render and handle booking form
     * 
     * @Route("/ads/{slug}/book", name="booking_create")
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @param Ad $ad
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function book(Ad $ad, ObjectManager $manager, Request $request)
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }
}
