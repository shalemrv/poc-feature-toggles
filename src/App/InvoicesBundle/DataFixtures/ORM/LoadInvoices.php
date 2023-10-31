<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use App\InvoicesBundle\Entity\Invoice;
use App\ProjectsBundle\Entity\Project;

class LoadInvoices implements FixtureInterface, OrderedFixtureInterface {
    
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $projects = $manager->getRepository(Project::class)->findAll();

        foreach($projects as $project) {
            echo PHP_EOL;
            
            echo "\tCreating Invoice for project - " . $project->getId();
            
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