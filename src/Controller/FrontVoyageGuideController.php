<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use App\Services\QrcodeService;
class FrontVoyageGuideController extends AbstractController
{
    #[Route('/voyage/front', name: 'app_front_voyage')]
    public function index(VoyageRepository $voyageRepository,BuilderInterface $customQrCodeBuilder): Response
    {
        
        /*$result = $customQrCodeBuilder
        ->size(400)
        ->margin(20)
        ->build();*/
    //$response = new QrCodeResponse($result);
        return $this->render('front_voyage_guide/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            //'qr' => $response
        ]);
    }
    


    #[Route('/reserver/{id}', name: 'reserver_voyage')]
    public function reserverVoyage(Voyage $voyage, Request $request): Response
    {
        // Récupérez le nombre de places disponibles
        $placesDisponibles = $voyage->getPlaceDisponible();

        // Vérifiez s'il y a des places disponibles
        if ($placesDisponibles > 0) {
            // Décrémentez le nombre de places disponibles
            $voyage->setPlaceDisponible($placesDisponibles - 1);

            // Enregistrez les changements dans la base de données
            $this->getDoctrine()->getManager()->flush();

            // Ajoutez un message flash pour informer l'utilisateur
            $this->addFlash('success', 'Réservation réussie !');

            // Redirigez l'utilisateur vers une page de confirmation ou une autre page pertinente
            return $this->redirectToRoute('app_front_voyage');
        } else {
            // Ajoutez un message flash pour informer l'utilisateur qu'il n'y a plus de places disponibles
            $this->addFlash('error', 'Désolé, il n\'y a plus de places disponibles.');

            // Redirigez l'utilisateur vers une page d'erreur ou une autre page pertinente
            return $this->redirectToRoute('app_front_voyage');
        }
    }

}
