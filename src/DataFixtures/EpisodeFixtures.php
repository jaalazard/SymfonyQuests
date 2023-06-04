<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Episode;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 500; $i++) {

            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setTitle($faker->city());
            $episode->setSynopsis($faker->paragraphs(3, true));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 10)));
            $episode->setDuration($faker->numberBetween(20, 120));
            $this->addReference('episode_' . $i, $episode);
            $manager->persist($episode);
        }
        $manager->flush();
    }

       public function getDependencies()
       {
           // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
           return [
               SeasonFixtures::class,
           ];
        }
    }
