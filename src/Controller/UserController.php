<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\userRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    #[Route('/user/utilisateur', name: 'app_list')]
    public function index(EntityManagerInterface $entityManager): Response
{
    $userRepository = $entityManager->getRepository(User::class);
    $utilisateurs = $userRepository->findAll();

    return $this->render('admin/listUser.html.twig', [
        'utilisateurs' => $utilisateurs,
    ]);
}

#[Route('/user/delete/{id}', name: 'delete_user')]
public function delete(User $user, EntityManagerInterface $entityManager): Response
{
    // Remove the user from the database
    $entityManager->remove($user);
    $entityManager->flush();

    // Redirect to the user list page
    return $this->redirectToRoute('app_list');
}

#[Route('/index', name: 'app_index')]
public function index1(Request $request, EntityManagerInterface $entityManager): Response
{
    // Récupérer l'utilisateur actuel
    $user = $this->getUser();

    // Créer un formulaire pour la modification de l'utilisateur
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    // Vérifier si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

        // Mettre à jour l'utilisateur dans la base de données
        $entityManager->flush();

        // Ajouter un message de succès dans la variable de session Flash
        $this->addFlash('success', 'Les modifications ont été enregistrées avec succès.');

        // Rediriger vers la liste des utilisateurs après la modification
        return $this->redirectToRoute('app_index');
    }

    // Afficher le formulaire de modification d'utilisateur avec un éventuel message de succès
    return $this->render('admin/index.html.twig', [
        'form' => $form->createView(),
        'user' => $user,
    ]);
}


    #[Route('/', name: 'home')]
    public function index2(): Response
    {
        return $this->render('admin/home.html.twig', [
            
            
        ]);
    }
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/new.html.twig', [
            'user' => $user,
        ]);
    }

    
    #[Route('/user/add', name: 'add_user')]
public function add(Request $request, EntityManagerInterface $entityManager): Response
{
    $user = new User(); // Créer une nouvelle instance de l'entité User

    // Créer un formulaire pour l'ajout d'utilisateur
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    // Vérifier si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Ajouter l'utilisateur à la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        // Rediriger vers la liste des utilisateurs après l'ajout
        return $this->redirectToRoute('app_list');
    }

    // Afficher le formulaire d'ajout d'utilisateur
    return $this->render('admin/add_user.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/user/edit/{id}', name: 'edit_user')]
public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
{
    // Créer un formulaire pour la modification de l'utilisateur
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    // Vérifier si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Mettre à jour l'utilisateur dans la base de données
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

        // Mettre à jour l'utilisateur dans la base de données
        $entityManager->flush();

        // Ajouter un message de succès dans la variable de session Flash
        $this->addFlash('success', 'Les modifications ont été enregistrées avec succès.');


        // Rediriger vers la liste des utilisateurs après la modification
        return $this->redirectToRoute('app_list');
    }

    // Afficher le formulaire de modification d'utilisateur
    return $this->render('admin/edit_user.html.twig', [
        'form' => $form->createView(),
        'user' => $user,
    ]);
}


    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete2(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    
    

    
}

