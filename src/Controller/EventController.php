<?php

namespace App\Controller;
use App\services\messagerie;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Form\ParticipantType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twilio\Rest\Client;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('frontoffice/event/index.html.twig', [
            'events' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/event/details/{id}', name: 'app_event_details', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('frontoffice/event/details.html.twig', [
            'e' => $evenement,
        ]);
    }
    #[Route('/newp', name: 'app_participant')]
    public function new(Request $request, MailerInterface $mailer , messagerie $messagerie): Response
    {
        
        $form = $this->createForm(ParticipantType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Les données du formulaire sont disponibles ici
            $data = $form->getData();
            $emailBody = sprintf(
                "Nouveau participant\nNom: %s\nPrénom: %s\nNuméro: %s",
                $data['nom'],
                $data['prenom'],
                $data['numero']
            );
            $email = (new Email())
        ->from('skander.hrayech@esprit.tn')
        ->To('skander.arab@outlook.fr')
        ->subject('nouveau participant')
                ->text($emailBody);
            
                $mailer->send($email);
             
            // Faites quelque chose avec les données, par exemple, affichez-les

            $accountSid = 'AC3f0be4a4963fb3e11aec590d6db0b2d8';
            $authToken = '80fc1dbedaff9e0faab936d52993278a';
            $client = new Client($accountSid, $authToken);
    
            $message = $client->messages->create(
                '+21624547031', // replace with admin's phone number
                [
                    'from' => '+18589055740', // replace with your Twilio phone number
                    'body' => 'votre reservation a été confirimée',
                ]
            );
            dump($data);
            return $this->redirectToRoute('app_event', [], Response::HTTP_SEE_OTHER);
        }

          
        // flasher : 
        $messagerie->addSuccess(' merci pour votre visite ! un sms de confirmation va etre envoyer a votre numero ');


        return $this->renderForm('frontoffice/event/participer.html.twig', [
            
            'form' => $form,
        ]);
    }
}
