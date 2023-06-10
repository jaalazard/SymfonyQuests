<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProgramRepository;


class DefaultController extends AbstractController

{
    #[Route('/', name: 'app_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('index.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/myprofile', name: 'compte')]
    public function account(): Response
    {
        $user = $this->getUser();
        return $this->render('account.html.twig', ['user' => $user]);
    }
}
