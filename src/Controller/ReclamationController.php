<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\ReclamationRepository;
/**
 * @Route("/admin/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $query = $entityManager->getRepository(Reclamation::class)->createQueryBuilder('r')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5 // Items per page
        );

        return $this->render('reclamation/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="app_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    /**
     * @Route("/export/excel", name="app_reclamation_export_excel", methods={"GET"})
     */
    public function exportExcel(ReclamationRepository $reclamationRepository): Response
    {
        // Get all reclamations
        $reclamations = $reclamationRepository->findAll();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers
        $headers = ['Id', 'Contenu', 'Email', 'Nom', 'Prénom', 'Téléphone'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column.'1', $header);
            $column++;
        }

        // Set data rows
        $row = 2;
        foreach ($reclamations as $reclamation) {
            $sheet->setCellValue('A'.$row, $reclamation->getId());
            $sheet->setCellValue('B'.$row, $reclamation->getContenuReclamation());
            $sheet->setCellValue('C'.$row, $reclamation->getEmail());
            $sheet->setCellValue('D'.$row, $reclamation->getName());

            $row++;
        }

        // Create the Excel file
        $filename = 'reclamations.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Create a Response to send the file to the user
        $response = new Response(file_get_contents($filename));
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
        $response->headers->set('Cache-Control', 'max-age=0');

        // Delete the temporary file
        unlink($filename);

        return $response;
    }

    /**
     * @Route("/{id}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
