<?php


namespace App\DataFixtures;


use App\Entity\Program;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Doctrine\Persistence\ObjectManager;


class ProgramFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setTitle('Walking dead');
        $program->setSynopsis('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('The Simpsons');
        $program->setSynopsis('Synopsis of The Simpsons');
        $program->setCategory($this->getReference('category_Animation'));
        $manager->persist($program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('X Files');
        $program->setSynopsis('Synopsys of X Files');
        $program->setCategory($this->getReference('category_Fantastique'));
        $manager->persist($program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('American Horror Story');
        $program->setSynopsis('flippant');
        $program->setCategory($this->getReference('category_Horreur'));
        $manager->persist($program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('The last of us');
        $program->setSynopsis('quelle aventure');
        $program->setCategory($this->getReference('category_Aventure'));
        $manager->persist($program);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }


}