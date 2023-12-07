<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\BookingRestaurant;
use App\Form\RestaurantType;
use App\Form\BookingRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="app_restaurant_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $restaurants = $entityManager
            ->getRepository(Restaurant::class)
            ->findAll();

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * @Route("/new", name="app_restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_restaurant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurant_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/hotel/{id}/book", name="book_nowRes", methods={"GET","POST"})
     */
    public function bookNow(Request $request, Restaurant $restaurant): Response
    {
        $booking = new BookingRestaurant();
        $booking->setRestaurant($restaurant);

        // Set the default user ID
        $booking->setUserId(1);

        $form = $this->createForm(BookingRestaurantType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Subtract 'nombre' from 'numberOfTable'
            $numberOfTable = $restaurant->getNumberOfTable();
            $nombre = $booking->getNombre();

            if ($numberOfTable >= $nombre) {
                // If there are enough tables, proceed with booking
                $restaurant->setNumberOfTable($numberOfTable - $nombre);

                $entityManager->persist($booking);
                $entityManager->persist($restaurant);

                $entityManager->flush();

                $this->addFlash('success', 'Booking successful!');

                return $this->redirectToRoute('app_restaurant_index');
            } else {
                $this->addFlash('danger', 'Not enough tables available for booking.');
            }
        }

        return $this->render('restaurant/book_now.html.twig', [
            'form' => $form->createView(),
            'restaurant' => $restaurant,
        ]);
    }
}
