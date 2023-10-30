<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use DateTime;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\ProjectsBundle\Entity\Project;

class LoadProjects implements FixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        for ($i = 1; $i <= 3; $i++) {
            echo "\nCreating Project $i";

            $project = new Project();

            $project->setName('DocFix - Project - ' . rand(100,999));
            $project->setDescription('This was added by Doctrine fixtures');
            $project->setStartTime();
            $project->setEndTime('tomorrow');

            $manager->persist($project);

            echo PHP_EOL;
        }

        $manager->flush();
    }
}