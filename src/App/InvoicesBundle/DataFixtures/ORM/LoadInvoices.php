<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use DateTime;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\InvoicesBundle\Entity\Invoice;
use App\ProjectsBundle\Entity\Project;
use App\FeatureTogglesBundle\Entity\FeatureFlag;


class LoadInvoices implements FixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $projects = $manager->getRepository(Project::class)->findAll();

        foreach($projects as $project) {
            echo "Creating Invoice for project - " . $project->getId();
            
            $invoice = new Invoice();
        
            $invoice->setProject($project);
            $invoice->setInvoiceNumber(rand(10000,99999));
            $invoice->setAmount(rand(100000,999999) / 100);

            $manager->persist($invoice);

            echo PHP_EOL;
        }
        
        $manager->flush();

    }
}