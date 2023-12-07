<?php

namespace App\Controller;
use App\Entity\Billet;
use App\Repository\BilletRepository;
use App\Form\BilletType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\BuilderInterface; 
use Endroid\QrCode\Writer\Result\PngResult;

/**
 * @Route("/admin/billet")
 */
class BilletController extends AbstractController
{
    private $qrCodeBuilder;

    public function __construct(BuilderInterface $qrCodeBuilder)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
    }

    /**
     * @Route("/", name="app_billet_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,BilletRepository $billetRepository): Response
    {

        $billets = $billetRepository->findAll();
        foreach ($billets as $billet) {
            // Customize the QR code data (use the hotel name as an example)
            $qrCodeResult = $this->qrCodeBuilder
                ->data($billet->getNomBillet())
                ->build();

            // Convert the QR code result to a string representation
            $qrCodeString = $this->convertQrCodeResultToString($qrCodeResult);

            // Add the QR code string to the hotel entity
            $billet->setQrCode($qrCodeString);
        }
        
        return $this->render('billet/index.html.twig', [
            'billets' => $billets,
        ]);
    }
    private function convertQrCodeResultToString(\Endroid\QrCode\Writer\Result\PngResult $qrCodeResult): string
    {
        // Convert the result to a string (e.g., base64 encode the image)
        // Adjust this logic based on how you want to represent the QR code data
        return 'data:image/png;base64,' . base64_encode($qrCodeResult->getString());
    }
    

    /**
     * @Route("/new", name="app_billet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $billet = new Billet();
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($billet);
            $entityManager->flush();

            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('billet/new.html.twig', [
            'billet' => $billet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_show", methods={"GET"})
     */
    public function show(Billet $billet): Response
    {
        return $this->render('billet/show.html.twig', [
            'billet' => $billet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_billet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Billet $billet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('billet/edit.html.twig', [
            'billet' => $billet,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_billet_delete", methods={"POST"})
     */
    public function delete(Request $request, Billet $billet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($billet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_billet_index', [], Response::HTTP_SEE_OTHER);
    }
}
