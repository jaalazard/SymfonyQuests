<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\ProgramDuration;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);
            $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to('your_email@example.com')
            ->subject('Une nouvelle série vient d\'être publiée!')
            ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));
            $this->addFlash('success', 'The new program has been created');
            $this->addFlash('danger', 'The new program has been deleted');
            
            return $this->redirectToRoute('program_index');
    }
        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program)
        ]);
    }

    #[Route('/{slug}/season/{season}', requirements: ['season' => '\d+'], methods: ['GET'], name: 'season_show')]
    public function showSeason(Season $season, Program $program): Response
    {
        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }

    #[Route('/{slug}/season/{season}/episode/{episode}', requirements: ['season' => '\d+'], methods: ['GET'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response{
        return $this->render('program/episode_show.html.twig',['program' => $program, 'season' => $season , 'episode' => $episode]);
    }
}
