<?php

namespace App\Controller;

use App\Entity\BookingVol;
use App\Form\BookingVol1Type;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bookingvol")
 */
class BookingVolController extends AbstractController
{
    /**
     * @Route("/", name="app_booking_vol_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking_vol/index.html.twig', [
            'booking_vols' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_booking_vol_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $bookingVol = new BookingVol();
        $form = $this->createForm(BookingVol1Type::class, $bookingVol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($bookingVol, true);

            return $this->redirectToRoute('app_booking_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_vol/new.html.twig', [
            'booking_vol' => $bookingVol,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_vol_show", methods={"GET"})
     */
    public function show(BookingVol $bookingVol): Response
    {
        return $this->render('booking_vol/show.html.twig', [
            'booking_vol' => $bookingVol,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_booking_vol_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BookingVol $bookingVol, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingVol1Type::class, $bookingVol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($bookingVol, true);

            return $this->redirectToRoute('app_booking_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_vol/edit.html.twig', [
            'booking_vol' => $bookingVol,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_vol_delete", methods={"POST"})
     */
    public function delete(Request $request, BookingVol $bookingVol, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookingVol->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($bookingVol, true);
        }

        return $this->redirectToRoute('app_booking_vol_index', [], Response::HTTP_SEE_OTHER);
    }
}
