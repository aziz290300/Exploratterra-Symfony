<?php
// src/Controller/TypeController.php
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
 * @Route("/vol")
 */
class VolFrontController extends AbstractController
{
    

     /**
     * @Route("/{id}/book", name="book_vol", methods={"GET","POST"})
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

                return $this->redirectToRoute('vol_index');
            } else {
                $this->addFlash('danger', 'Not enough available nombre for booking.');
            }
        }

        return $this->render('front/bookvol.html.twig', [
            'form' => $form->createView(),
            'vol' => $vol,
        ]);
    }


    /**
     * @Route("/vol", name="vol_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vols = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('front/vol.html.twig', [
            'vols' => $vols,
        ]);
    }

}
