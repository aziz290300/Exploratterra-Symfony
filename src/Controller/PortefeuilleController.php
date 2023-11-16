<?php

namespace App\Controller;

use App\Entity\Portefeuille;
use App\Entity\PortefeuilleRepository;
use App\Form\PortefeuilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/portefeuille')]
class PortefeuilleController extends AbstractController
{
    #[Route('/', name: 'app_portefeuille_index', methods: ['GET'])]
    public function index(PortefeuilleRepository $portefeuilleRepository): Response
    {
        return $this->render('portefeuille/index.html.twig', [
            'portefeuilles' => $portefeuilleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portefeuille_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portefeuille = new Portefeuille();
        $form = $this->createForm(PortefeuilleType::class, $portefeuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($portefeuille);
            $entityManager->flush();

            return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuille/new.html.twig', [
            'portefeuille' => $portefeuille,
            'form' => $form,
        ]);
    }

    #[Route('/{idportefeuille}', name: 'app_portefeuille_show', methods: ['GET'])]
    public function show(Portefeuille $portefeuille): Response
    {
        return $this->render('portefeuille/show.html.twig', [
            'portefeuille' => $portefeuille,
        ]);
    }

    #[Route('/{idportefeuille}/edit', name: 'app_portefeuille_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portefeuille $portefeuille, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortefeuilleType::class, $portefeuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuille/edit.html.twig', [
            'portefeuille' => $portefeuille,
            'form' => $form,
        ]);
    }

    #[Route('/{idportefeuille}', name: 'app_portefeuille_delete', methods: ['POST'])]
    public function delete(Request $request, Portefeuille $portefeuille, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portefeuille->getIdportefeuille(), $request->request->get('_token'))) {
            $entityManager->remove($portefeuille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_portefeuille_index', [], Response::HTTP_SEE_OTHER);
    }
}
