<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;
use App\Entity\Actor;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $actor = new Actor();
            $actor->setName($faker->name());

            $programs = $manager->getRepository(Program::class)->findAll();
            $randomPrograms = $faker->randomElements($programs, 3);
            foreach($randomPrograms as $randomProgram){
                $actor->addProgram($randomProgram);
            }
            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}
