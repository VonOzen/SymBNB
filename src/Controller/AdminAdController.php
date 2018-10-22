<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Service\Pagination;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * Get all ads for administration
     * 
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads_index")
     * 
     * @param AdRepository $repo
     * @param Integer $page
     * @param Pagination $pagination
     * @return Response
     */
    public function index(AdRepository $repo, $page, Pagination $pagination)
    {
        $pagination->setEntityClass(Ad::class)
                   ->setcurrentPage($page);

        return $this->render('admin/ad/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Allow admin to edit ad
     * 
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     *
     * @param Ad $ad
     * @param Request $_REQUEST
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AnnonceType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "Changes for \"<strong>{$ad->getTitle()}</strong>\" have been saved !"
            );
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Allow admin to delete an ad
     * 
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     *
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Ad $ad, ObjectManager $manager)
    {
        if(count($ad->getBookings()) > 0) {
            $this->addFlash(
                'warning',
                "You can't delete ad \"<strong>{$ad->getTitle()}</strong>\" because " . count($ad->getBookings()) . " booking(s) are related."
            );
        } else {

            $manager->remove($ad);
            $manager->flush();
    
            $this->addFlash(
                'success',
                "Ad \"<strong>{$ad->getTitle()}</strong>\" has been removed !"
            );
        }

        return $this->redirectToRoute('admin_ads_index');
    }
}
