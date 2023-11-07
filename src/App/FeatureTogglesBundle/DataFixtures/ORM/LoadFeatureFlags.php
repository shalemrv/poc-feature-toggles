<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use App\FeatureTogglesBundle\Entity\FeatureFlag;

class LoadLoadFeatureFlags implements FixtureInterface, OrderedFixtureInterface {
    
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        
        $featureFlag1 = new FeatureFlag();

        $featureFlag1->setName(FeatureFlag::INVOICE_GENERATION_MICROSERVICE);
        $featureFlag1->setActive(false);
        $featureFlag1->setPercentage(15);
        
        $featureFlag2 = new FeatureFlag();

        $featureFlag2->setName(FeatureFlag::TASK_MANAGEMENT_MICROSERVICE);
        $featureFlag2->setActive(true);
        $featureFlag2->setPercentage(100);

        $manager->persist($featureFlag1);
        $manager->persist($featureFlag2);
        
        $manager->flush();
    }
}