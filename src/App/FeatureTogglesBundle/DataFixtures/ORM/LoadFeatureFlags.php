<?php

namespace App\ProjectsBundle\DataFixtures\ORM;

use DateTime;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\FeatureTogglesBundle\Entity\FeatureFlag;


class LoadLoadFeatureFlags implements FixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        
        $featureFlag1 = new FeatureFlag();

        $featureFlag1->setName(FeatureFlag::INVOICE_GENERATION_MICROSERVICE);
        $featureFlag1->setActive(false);
        $featureFlag1->setPercentage(100);
        
        $featureFlag2 = new FeatureFlag();

        $featureFlag2->setName(FeatureFlag::TASK_MANAGEMENT_MICROSERVICE);
        $featureFlag2->setActive(true);
        $featureFlag2->setPercentage(100);

        $manager->persist($featureFlag1);
        $manager->persist($featureFlag2);
        
        $manager->flush();
    }
}