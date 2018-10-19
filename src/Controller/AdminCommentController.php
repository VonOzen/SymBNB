<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Get all comments for administration
     * 
     * @Route("/admin/comments", name="admin_comments_index")
     * 
     * @param CommentRepository $repo
     * @return Response
     */
    public function index(CommentRepository $repo)
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $repo->findAll()
        ]);
    }

    /**
     * Allow admin comment edition
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comments_edit")
     *
     * @param Comment $comment
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Comment $comment, ObjectManager $manager, Request $request)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Comment n°<strong>{$comment->getId()}</strong> has been successfully edited !"
            );

            return $this->redirectToRoute('admin_comments_index');
        }

        return $this->render('admin/comment/edit.html.twig', 
        [
            'comment' => $comment,
            'form'    => $form->createView()
        ]);
    }

    /**
     * Allow admin comment delete
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete")
     *
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Comment $comment, ObjectManager $manager)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "{$comment->getAuthor()->getFullName()}'s comment has been deleted !"
        );

        return $this->redirectToRoute('admin_comments_index');
    }
}
