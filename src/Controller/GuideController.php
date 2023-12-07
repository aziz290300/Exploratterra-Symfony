<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Form\GuideType;
use App\Form\ContractType;
use App\Form\EmailformType;
use App\Repository\GuideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/guide')]
class GuideController extends AbstractController
{
    #[Route('/invit', name: 'app_invit')]
    public function newinvit(Request $request, MailerInterface $mailer): Response
    {
        
        $form = $this->createForm(EmailformType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $emailBody = sprintf(
                "Cher  %s  %s j'espère que vous allez bien\n je planifie un voyage organisé, si vous avez des informations sur vos disponibilités, vos tarifs et toute autre modalité pertinente, je vous serais reconnaissant de bien vouloir les partager.\n\nMerci beaucoup pour votre temps et votre considération. J'attends avec impatience votre réponse.  \n\nCordialement,\nAgence de voyages XXXXX\nagenceXXX@gmail.com\nTel 54684684",
                $data['nom'],
                $data['prenom']

            );
            $email = (new Email())
            ->from('bensalehchayma3@gmail.com')
            ->To($data['email'])
            ->subject('Confirmation de disponibilté')
            ->text($emailBody);
            $mailer->send($email);
        return $this->redirectToRoute('app_guide_index');
        dump($data);
            
        }
        return $this->renderForm('guide/invit.html.twig', [
            
            'form' => $form,
        ]);
    }
    #[Route('/newcontarct', name: 'app_contract')]
    public function newcontarct(Request $request): Response
    {
        
        $form = $this->createForm(ContractType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();
                $pdf = new TCPDF();
                $pdf->SetMargins(20, 20, 20);
                $pdf->AddPage();
                

                $logoFile = '../public/E.png';
                $pdf->Image($logoFile, $x = 15, $y = 15, $w = 40, $h = 40, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = '');
                
                // Personnalisation du contrat
                $pdf->SetFont('Helvetica', 'B', 16);
                //$pdf->Cell(0, 50, 'Contrat de travail pour guide touristique', 0, 1, 'C');
            //$pdf->SetTextColor(0, 74, 173); // Couleur #004AAD en RGB
            $pdf->Cell(0, 50, 'Contrat de travail pour guide touristique', 0, 1, 'C', false, '', 0, false, 'T', 'C');



                $pdf->Ln(10);
                
                $pdf->SetFont('Helvetica', '', 12);

            $pdf->Cell(0, 10, 'Entre lemployeur : XXXX et le guide touristique : ', 0, 'C');

                $pdf->MultiCell(0, 10, 'Prénom: '.$data['prenom'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Nom: '.$data['nom'], 0, 'L');
                $pdf->MultiCell(0, 10, 'Numero de CIN: '.$data['numero_de_CIN'], 0, 'L');

            $pdf->Cell(0, 10, 'Le guide touristique est embauché pour fournir des services de guidage touristique à', 0, 'C');

                $pdf->MultiCell(0, 10, 'Destination: '.$data['Voyage'], 0, 'L');
            $pdf->Cell(0, 10, 'pendant la periode entre : ', 0, 'C');
                $pdf->MultiCell(0, 10, 'date de debut: '.$data['date_debut'], 0, 'L');
                $pdf->MultiCell(0, 10, 'date fin: '.$data['date_fin'], 0, 'L');
            $pdf->Cell(0, 10, 'avec un salaire journalier ', 0, 'C');
                $pdf->MultiCell(0, 10, 'Salaire: '.$data['salaire'], 0, 'L');




                $pdf->SetXY($pdf->GetPageWidth() - 120, $pdf->GetPageHeight() - 40);
                $pdf->SetFont('Helvetica', 'B', 12);
                $pdf->Cell(100, 10, 'Signature du guide: ________', 0, 0, 'R');

            $pdf->SetXY($pdf->GetPageWidth() - 120, $pdf->GetPageHeight() - 60);
            $pdf->SetFont('Helvetica', 'B', 12);
                $pdf->Cell(100, 10, 'Signature du responsable: ________', 0, 0, 'R');
                
                // Ajout de la date d'aujourd'hui
                $pdf->SetY(20);
                $pdf->SetX(150);
                $pdf->MultiCell(0, 10, 'Date: '.date('Y-m-d'), 0, 'R');
                
                // Téléchargement du fichier PDF
                $pdf->Output('contrat_guide.pdf', 'D');
                return $this->redirectToRoute('app_guide_index');
            dump($data);
            
        }
        return $this->renderForm('guide/contract.html.twig', [
            
            'form' => $form,
        ]);
    }
    #[Route('/', name: 'app_guide_index', methods: ['GET'])]
    public function index(GuideRepository $guideRepository): Response
    {
        return $this->render('guide/index.html.twig', [
            'guides' => $guideRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_guide_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $guide = new Guide();
    $form = $this->createForm(GuideType::class, $guide);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $guideRepository = $this->getDoctrine()->getRepository(Guide::class);
        $guideP = $guideRepository->findOneBy(['prenom' => $guide->getPrenom()]);

        if ($guideP) {
            $this->addFlash('error', 'Guide already exists');
        } else {
            $entityManager->persist($guide);
            $entityManager->flush();
           
            return $this->redirectToRoute('app_guide_index');
        }
    }

    return $this->renderForm('guide/new.html.twig', [
        'guide' => $guide,
        'form' => $form,
    ]);
}




    #[Route('/{id}', name: 'app_guide_show', methods: ['GET'])]
    public function show(Guide $guide): Response
    {
        return $this->render('guide/show.html.twig', [
            'guide' => $guide,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_guide_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guide $guide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuideType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guide/edit.html.twig', [
            'guide' => $guide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guide_delete', methods: ['POST'])]
    public function delete(Request $request, Guide $guide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guide->getId(), $request->request->get('_token'))) {
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
    }


}
