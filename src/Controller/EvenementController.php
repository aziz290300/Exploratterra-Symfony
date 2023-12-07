<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CategorieRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
#[Route('/evenement')]
class EvenementController extends AbstractController
{

    /**
 * @Route("/stat1" , name="stat1")
 */
public function stat(CategorieRepository $categorieRepository)
{
    // Get all categories
    $categories = $categorieRepository->findAll();

    $eventCountByCategory = [];
    foreach ($categories as $category) {
        $eventCountByCategory[$category->getNom()] = count($category->getEvents());
    }

    $eventChart = new PieChart();
    $eventChart->getData()->setArrayToDataTable(
        array_merge([['Category', 'Number of Events']], array_map(
            function ($category, $count) {
                return [$category, $count];
            },
            array_keys($eventCountByCategory),
            $eventCountByCategory
        ))
    );
    $eventChart->getOptions()->setTitle("Number of Events by Category");
    $eventChart->getOptions()->setHeight(400);
    $eventChart->getOptions()->setIs3D(2);
    $eventChart->getOptions()->setWidth(550);
    $eventChart->getOptions()->getTitleTextStyle()->setBold(true);
    $eventChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $eventChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $eventChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $eventChart->getOptions()->getTitleTextStyle()->setFontSize(15);

    return $this->render('frontoffice/event/stat1.html.twig', [
        'eventChart' => $eventChart,
    ]);}
    /**
     * @Route("/export-events", name="export_events")
     */
    public function exportEvents(): Response
    {
        // Retrieve the list of events (replace this with your actual logic)
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        $response = new StreamedResponse(function () use ($events) {
            $handle = fopen('php://output', 'w+');
    
            // Add CSV headers
            fwrite($handle, "ID;Nom;Date de début;Lieu;Tarif;Catégorie\n");
    
            // Add data
            foreach ($events as $event) {
    fputcsv($handle, [
        $event->getId(),
        $event->getNom(),
        $event->getDateDebut() ? $event->getDateDebut()->format('Y-m-d') : '',
        $event->getLieu(),
        $event->getTarif(),
        $event->getCategorie()->getNom(),
    ], ';');
}
    
            fclose($handle);
        });
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="events.csv"');
    
        return $response;
    }
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $evenementRepository->findAll();

        $event = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            1
        );
        return $this->render('backoffice/event/index.html.twig', [
            'events' => $event,
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('my_images_directory'), $fileName);
                $evenement->setImage($fileName);
            }
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/event/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('backoffice/event/show.html.twig', [
            'e' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('my_images_directory'), $fileName);
                $evenement->setImage($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/event/edit.html.twig', [
            'e' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
}
