<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Booking;
use App\Form\BookingType;
use Knp\Snappy\Pdf;
use Knp\Component\Pager\PaginatorInterface;

class HotelFrontController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel_index", methods={"GET"})
     */
    public function index1(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $query = $entityManager->getRepository(Hotel::class)->createQueryBuilder('r')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3 // Items per page
        );

        return $this->render('front/hotel.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
