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


/**
 * @Route("/admin/hotel")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="app_hotel_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $query = $entityManager->getRepository(Hotel::class)->createQueryBuilder('r')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3 // Items per page
        );

        return $this->render('hotel/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="app_hotel_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
    $hotel = new Hotel();
    $form = $this->createForm(HotelType::class, $hotel);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload
        /** @var UploadedFile $file */
        $file = $form['imageHotel']->getData();

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
            $hotel->setImageHotel($fileName);
        }

        // Save the hotel entity
        $entityManager->persist($hotel);
        $entityManager->flush();

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('hotel/new.html.twig', [
        'hotel' => $hotel,
        'form' => $form,
    ]);
}

    /**
     * @Route("/{id}", name="app_hotel_show", methods={"GET"})
     */
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_hotel_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            /** @var UploadedFile $file */
            $file = $form['imageHotel']->getData();

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

                // Delete the old file if it exists
                $oldFile = $hotel->getImageHotel();
                if ($oldFile) {
                    unlink($this->getParameter('uploadsdir').'/'.$oldFile);
                }

                // Store the new file name in the entity
                $hotel->setImageHotel($fileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_hotel_delete", methods={"POST"})
     */
    public function delete(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }

 
    /**
     * @Route("/{id}/book", name="book_nowHotel", methods={"GET","POST"})
     */
     public function bookNow(Request $request, Hotel $hotel): Response
    {
        $booking = new Booking();
        $booking->setHotel($hotel);

        // Set the default user ID
        $booking->setUserId(1);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Subtract 'numberOfRooms' from 'numberOfRooms'
            $numberOfRooms = $hotel->getNumberOfRooms();
            $bookedNumberOfRooms = $booking->getNombre();

            if ($numberOfRooms >= $bookedNumberOfRooms) {
                // If there are enough rooms, proceed with booking
                $hotel->setNumberOfRooms($numberOfRooms - $bookedNumberOfRooms);

                $entityManager->persist($booking);
                $entityManager->persist($hotel);

                $entityManager->flush();

                $this->addFlash('success', 'Booking successful!');

                return $this->redirectToRoute('app_hotel_index');
            } else {
                $this->addFlash('danger', 'Not enough rooms available for booking.');
            }
        }

        return $this->render('hotel/book_now.html.twig', [
            'form' => $form->createView(),
            'hotel' => $hotel,
        ]);
    }
    /**
     * @Route("/export-pdf", name="app_hotel_export_pdf", methods={"GET"})
     */
    public function exportPdf(EntityManagerInterface $entityManager, \Knp\Snappy\Pdf $knpSnappyPdf): Response
    {
        $hotels = $entityManager
            ->getRepository(Hotel::class)
            ->findAll();

        $html = $this->renderView('hotel/pdf_template.html.twig', ['hotels' => $hotels]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'hotels_export.pdf'
        );
    }

}
