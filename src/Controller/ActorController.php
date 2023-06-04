<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ActorType;
use App\Entity\Actor;
use Symfony\Component\HttpFoundation\Request;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    // #[Route('/', name: 'index')]
    // public function index(ActorRepository $actorRepository): Response
    // {
    //     $actors = $actorRepository->findAll();
    //     return $this->render('actor/index.html.twig', [
    //        'actors' => $actors,
    //     ]);
    // }

    // #[Route('/new', name: 'new')]
    // public function new(Request $request, ActorRepository $actorRepository): Response
    // {
    //     $actor = new Actor();
    //     $form = $this->createForm(ActorType::class, $actor);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted()) {
    //         $actorRepository->save($actor, true);
    //         return $this->redirectToRoute('actor_index');
    // }
    //     return $this->render('actor/new.html.twig', [
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'show')]
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }

}