<?php
namespace App\Controller;

use App\Repository\HotelRepository;
use App\Repository\BookingRepository;
use App\Repository\BookingVolRepository;
use App\Repository\BookingRestaurantRepository;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/admin/stats", name="app_stats")
     */
    public function index(
        HotelRepository $hotelRepository,
        BookingRepository $bookingRepository,
        BookingVolRepository $bookingVolRepository,
        BookingRestaurantRepository $bookingRestaurantRepository,
        ReclamationRepository $reclamationRepository
    ): Response {
        $hotelCount = $hotelRepository->count([]);
        $hotelReservationCount = $bookingRepository->count([]);
        $volReservationCount = $bookingVolRepository->count([]);
        $restaurantReservationCount = $bookingRestaurantRepository->count([]);
        $reclamationCount = $reclamationRepository->count([]);

        return $this->render('stats/index.html.twig', [
            'hotelCount' => $hotelCount,
            'hotelReservationCount' => $hotelReservationCount,
            'volReservationCount' => $volReservationCount,
            'restaurantReservationCount' => $restaurantReservationCount,
            'reclamationCount' => $reclamationCount,
        ]);
    }
}
