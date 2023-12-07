<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Entity\Billet;
use App\Entity\BookingVol;
use App\Form\VolType;
use App\Form\BookingVolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * @Route("/admin/vol")
 */
class VolController extends AbstractController
{
    /**
     * @Route("/", name="app_vol_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vols = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('vol/index.html.twig', [
            'vols' => $vols,
        ]);
    }

  /**
 * @Route("/new", name="app_vol_new", methods={"GET", "POST"})
 */
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $vol = new Vol();
    $form = $this->createForm(VolType::class, $vol);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form['image']->getData();

        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('uploadsdir'),
                    $fileName
                );
            } catch (FileException $e) {
                // Handle the exception if something goes wrong during file upload
            }

            // Store the file name in the entity
            $vol->setImage($fileName);
        }

        // Persist the Vol entity
        $entityManager->persist($vol);
        $entityManager->flush();

        // Create Billets based on the number in Vol
        $numberOfBillets = $vol->getNombre();
        for ($i = 0; $i < $numberOfBillets; $i++) {
            $billet = new Billet();
            $billet->setNomBillet('Billet ' . ($i + 1)); // You can set a name for the billet if needed
            $billet->setVol($vol);
            $entityManager->persist($billet);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('vol/new.html.twig', [
        'vol' => $vol,
        'form' => $form,
    ]);
}

/**
 * @Route("/{id}", name="app_vol_show", methods={"GET"})
 */
public function show(Vol $vol): Response
{
    return $this->render('vol/show.html.twig', [
        'vol' => $vol,
    ]);
}


    /**
     * @Route("/{id}/edit", name="app_vol_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vol_delete", methods={"POST"})
     */
    public function delete(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
    }
     /**
     * @Route("/{id}/book", name="book_nowVol", methods={"GET","POST"})
     */
    public function bookNow(Request $request, Vol $vol): Response
    {
        $booking = new BookingVol();
        $booking->setVolB($vol);

        // Set the default user ID
        $booking->setUserId(1);

        $form = $this->createForm(BookingVolType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Subtract 'nombre' from 'nombre'
            $availableNombre = $vol->getNombre();
            $bookedNombre = $booking->getNombre();

            if ($availableNombre >= $bookedNombre) {
                // If there are enough nombre, proceed with booking
                $vol->setNombre($availableNombre - $bookedNombre);

                $entityManager->persist($booking);
                $entityManager->persist($vol);

                $entityManager->flush();

                $this->addFlash('success', 'Booking successful!');

                return $this->redirectToRoute('app_vol_index');
            } else {
                $this->addFlash('danger', 'Not enough available nombre for booking.');
            }
        }

        return $this->render('vol/book_now.html.twig', [
            'form' => $form->createView(),
            'vol' => $vol,
        ]);
    }
}
