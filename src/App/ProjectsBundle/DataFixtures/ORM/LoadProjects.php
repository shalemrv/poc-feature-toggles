<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use App\ProjectsBundle\Entity\Project;

class LoadProjects implements FixtureInterface, OrderedFixtureInterface {
    
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $noOfDummyProjects = 10;

        for ($i = 1; $i <= $noOfDummyProjects; $i++) {
            echo PHP_EOL;

            echo "\tCreating Project $i";

            $project = new Project();

            $project->setName('DocFix - Project - ' . rand(100,999));
            $project->setDescription('This was added by Doctrine fixtures');
            $project->setStartTime();
            $project->setEndTime('tomorrow');

            $manager->persist($project);

            echo PHP_EOL;
        }

        $manager->flush();

        echo PHP_EOL;

    }
}