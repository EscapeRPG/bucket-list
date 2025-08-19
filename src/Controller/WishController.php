<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list')]
    public function list(WishRepository $wishRepository): Response
    {
        $criterias = ['isPublished' => 1];

        $wishes = $wishRepository->findBy($criterias, ['dateCreated' => 'DESC']);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    #[Route('/wish/detail/{id}', name: 'wish_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException('This wish does not exist, sorry!');
        }

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[Route('/wish/create', name: 'wish_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($wish);
            $em->flush();

            $this->addFlash('success', 'Idea was successfully added!');

            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'An error has occurred, please try again.');
        }

        return $this->render('wish/create.html.twig', [
            'wish_form' => $form,
        ]);
    }

    #[Route('/wish/update/{id}', name: 'wish_update', requirements: ['id' => '\d+'])]
    public function update(Wish $wish, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('update' . $wish->getId(), $request->get('token'))) {
            $form = $this->createForm(WishType::class, $wish);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush($form);

                $this->addFlash('success', 'Idea was successfully updated!');

                return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
            } elseif ($form->isSubmitted() && !$form->isValid()) {
                $this->addFlash('danger', 'An error has occurred, please try again.');
            }

            return $this->render('wish/create.html.twig', [
                'wish_form' => $form,
            ]);
        } else {
            $this->addFlash('danger', 'This action is unauthorized!.');
        }

        return $this->redirectToRoute('wish_list');
    }

    #[Route('/wish/delete/{id}', name: 'wish_delete', requirements: ['id' => '\d+'])]
    public function delete(Wish $wish, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->get('token'))) {
            $em->remove($wish);
            $em->flush();
            $this->addFlash('success', 'Idea was successfully deleted!');
        } else {
            $this->addFlash('danger', 'This action is unauthorized!.');
        }
        return $this->redirectToRoute('wish_list', ['id' => $wish->getId()]);
    }
}
