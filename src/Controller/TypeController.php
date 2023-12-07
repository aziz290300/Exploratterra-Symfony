<?php
// src/Controller/TypeController.php
namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

/**
 * @Route("/admin/type")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="app_type_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager
            ->getRepository(Type::class)
            ->findAll();

        return $this->render('type/index.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/new", name="app_type_new", methods={"GET", "POST"})
     */
   /**
 * @Route("/new", name="app_type_new", methods={"GET", "POST"})
 */
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $type = new Type();
    $form = $this->createForm(TypeType::class, $type);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Check for uniqueness before persisting
        $existingType = $entityManager->getRepository(Type::class)->findOneBy(['name' => $type->getName()]);

        if ($existingType) {
            // Handle duplication error (e.g., display a message to the user)
            // You can also add a custom error to the form if you want to display it in the template
            $form->addError(new FormError('Ce nom existe déjà.'));
        } else {
            // Proceed with persistence if not a duplicate
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_index');
        }
    }

    return $this->renderForm('type/new.html.twig', [
        'type' => $type,
        'form' => $form,
    ]);
}


    /**
     * @Route("/{id}", name="app_type_show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Type $type, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_delete", methods={"POST"})
     */
    public function delete(Request $request, Type $type, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
