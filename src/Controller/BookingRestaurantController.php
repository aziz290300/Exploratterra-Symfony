<?php

namespace App\Controller;


use App\Entity\BookingRestaurant;
use App\Form\BookingRestaurant1Type;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bookingrestaurant")
 */
class BookingRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_booking_restaurant_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking_restaurant/index.html.twig', [
            'booking_restaurants' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_booking_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $bookingRestaurant = new BookingRestaurant();
        $form = $this->createForm(BookingRestaurant1Type::class, $bookingRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($bookingRestaurant, true);

            return $this->redirectToRoute('app_booking_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_restaurant/new.html.twig', [
            'booking_restaurant' => $bookingRestaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_restaurant_show", methods={"GET"})
     */
    public function show(BookingRestaurant $bookingRestaurant): Response
    {
        return $this->render('booking_restaurant/show.html.twig', [
            'booking_restaurant' => $bookingRestaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_booking_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BookingRestaurant $bookingRestaurant, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingRestaurant1Type::class, $bookingRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($bookingRestaurant, true);

            return $this->redirectToRoute('app_booking_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking_restaurant/edit.html.twig', [
            'booking_restaurant' => $bookingRestaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, BookingRestaurant $bookingRestaurant, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookingRestaurant->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($bookingRestaurant, true);
        }

        return $this->redirectToRoute('app_booking_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
