<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['title' => 'Walking Dead', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'Action', 'country' => 'USA', 'year' => '2010',],
        ['title' => 'The Last Of Us', 'synopsis' => 'Une série d\'aventure', 'category' => 'Aventure', 'country' => 'USA', 'year' => '2010',],
        ['title' => 'The Simpsons', 'synopsis' => 'Une famille jaune','category' => 'Animation', 'country' => 'USA', 'year' => '2010',],
        ['title' => 'X Files', 'synopsis' => 'Une série fantastique', 'category' => 'Fantastique', 'country' => 'USA', 'year' => '2010',],
        ['title' => 'American Horrow Story', 'synopsis' => 'Une série qui fait peur', 'category' => 'Horreur', 'country' => 'USA', 'year' => '2010',],
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

        public function load(ObjectManager $manager)
       {   
        $i  = 1;
           foreach (self::PROGRAMS as $programName) {
               $program = new Program();
               $program
                ->setTitle($programName['title'])
                ->setSynopsis($programName['synopsis'])
                ->setCountry($programName['country'])
                ->setYear($programName['year'])
                ->setCategory($this->getReference('category_' . $programName['category']));
             $this->addReference('program_' . $i, $program);
             $slug = $this->slugger->slug($program->getTitle());
             $program->setSlug($slug);
             $manager->persist($program);
             $i++;
           }
           $manager->flush();
       }

       public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}

    