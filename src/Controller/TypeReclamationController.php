<?php

namespace App\Controller;

use App\Entity\TypeReclamation;
use App\Form\TypeReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type-reclamation")
 */
class TypeReclamationController extends AbstractController
{
    /**
     * @Route("/", name="app_type_reclamation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $typeReclamations = $entityManager
            ->getRepository(TypeReclamation::class)
            ->findAll();

        return $this->render('type_reclamation/index.html.twig', [
            'type_reclamations' => $typeReclamations,
        ]);
    }

    /**
     * @Route("/new", name="app_type_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeReclamation = new TypeReclamation();
        $form = $this->createForm(TypeReclamationType::class, $typeReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeReclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_reclamation/new.html.twig', [
            'type_reclamation' => $typeReclamation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_reclamation_show", methods={"GET"})
     */
    public function show(TypeReclamation $typeReclamation): Response
    {
        return $this->render('type_reclamation/show.html.twig', [
            'type_reclamation' => $typeReclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeReclamation $typeReclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeReclamationType::class, $typeReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_reclamation/edit.html.twig', [
            'type_reclamation' => $typeReclamation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeReclamation $typeReclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeReclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeReclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
