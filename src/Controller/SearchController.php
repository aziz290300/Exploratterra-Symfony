<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig');
    }

    #[Route('/search-user', name: 'app_search_user')]
    public function searchUser(Request $request, UserRepository $UserRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $user = [];
        } else {
            $user = $UserRepository->searchUser($searchTerm);
        }

        return $this->render('search/results.html.twig', [
            'searchTerm' => $searchTerm,
            'user' => $user,
        ]);
    }

    #[Route('/user/search', name: 'app_search1')]
    public function index1(): Response
    {
        return $this->render('search/index.html.twig');
    }

    #[Route('/user/search-posts', name: 'app_search_posts1')]
    public function searchPosts1(Request $request, UserRepository $UserRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $user = [];
        } else {
            $user = $UserRepository->searchUser($searchTerm);
        }

        return $this->render('search/results.html.twig', [
            'searchTerm' => $searchTerm,
            'user' => $user,
        ]);
    }
}