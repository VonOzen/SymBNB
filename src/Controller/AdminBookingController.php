<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * Get all bookings for administration
     * 
     * @Route("/admin/bookings", name="admin_bookings_index")
     * 
     * @param BookingRepository $repo
     * @return Response
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll()
        ]);
    }

    
    /**
     * Allow admin bookings edit
     * 
     * @Route("/admin/bookings/{id}/edit", name="admin_bookings_edit")
     *
     * @param Booking $booking
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setAmount(0);

            $manager->persist($booking); //unnecessary entity already exists
            $manager->flush();

            $this->addFlash(
                'success',
                "Booking n°<strong>{$booking->getId()}</strong> has been updated !"
            );

            return $this->redirectToRoute('admin_bookings_index');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'form'    => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * Allow admin booking delete
     * 
     * @Route("/admin/bookings/{id}/delete", name="admin_bookings_delete")
     *
     * @param Booking $booking
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager)
    {
        $manager->remove($booking);
        $manager->flush();
        
        $this->addFlash(
            'success',
            "{$booking->getBooker()->getFullName()}'s booking has been deleted !"
        );

        return $this->redirectToRoute('admin_bookings_index');
    }
}
