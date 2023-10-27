<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use DateTime;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\InvoicesBundle\Entity\Invoice;
use App\ProjectsBundle\Entity\Project;
use App\FeatureTogglesBundle\Entity\FeatureFlag;


class LoadProjectsInvoices implements FixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        
        $project1 = new Project();

        $project1->setName('DocFix - Project - ' . rand(100,999));
        $project1->setDescription('This was added by Doctrine fixtures');
        $project1->setStartTime(new DateTime());
        $project1->setEndTime(new DateTime('tomorrow'));

        $invoice1 = new Invoice();
        
        $invoice1->setProject($project1);
        $invoice1->setInvoiceNumber(rand(10000,99999));
        $invoice1->setAmount(rand(100000,999999) / 100);
        $invoice1->setDate($project1->getEndTime()->format('Y-m-d'));

        $manager->persist($project1);
        $manager->persist($invoice1);


        $project2 = new Project();

        $project2->setName('DocFix - Project - ' . rand(100,999));
        $project2->setDescription('This was added by Doctrine fixtures');
        $project2->setStartTime(new DateTime());
        $project2->setEndTime(new DateTime('tomorrow'));


        $invoice2 = new Invoice();
        
        $invoice2->setProject($project2);
        $invoice2->setInvoiceNumber(rand(10000,99999));
        $invoice2->setAmount(rand(100000,999999) / 100);
        $invoice2->setDate($project2->getEndTime()->format('Y-m-d'));
        
        $manager->persist($project2);
        $manager->persist($invoice2);

        $featureFlag = new FeatureFlag();

        $featureFlag->setName(FeatureFlag::FLAG_INVOICE_GENERATION_MICROSERVICE);
        $featureFlag->setActive(true);
        $featureFlag->setPercentage(100);

        $manager->persist($featureFlag);
        
        $manager->flush();
    }
}