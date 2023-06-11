<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Repository\EpisodeRepository;

#[AsTwigComponent('last_episode')]
final class LastEpisodeComponent
{
    public function __construct(
        private EpisodeRepository $episodeRepository) {
    }

    public function getEpisodes(): array

    {
        return $this->episodeRepository->findBy([], ['id' => 'DESC']);
    }
}
