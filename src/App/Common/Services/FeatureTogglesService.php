<?php

namespace App\Common\Services;

use Doctrine\ORM\EntityManager;

use App\FeatureTogglesBundle\Entity\FeatureFlag;

class FeatureTogglesService {

    private $flags = [];

    private $em;
    
    public function __construct(EntityManager $em) {

        $this->em = $em;
        
        $this->updateFlags();
    }

    public function getFlags() {
        return $this->flags;
    }

    public function updateFlags() {
        
        $featureFlags = $this->em->getRepository(FeatureFlag::class)->findBy([
            FeatureFlag::ACTIVE => true
        ]);
        
        $this->flags = [];

        foreach ($featureFlags as $flag) {
            if ($flag->getPercentage() > 0)
                $this->flags[$flag->getName()] = $flag->getPercentage();
        }
    }

    public function isAllowed($flagName, $id = 0) {
        
        // If Flag is not active or does not exist
        if (!isset($this->flags[$flagName]))
            return false;

        $percentageAllowed = $this->flags[$flagName];
        
        // If $id is in the allowed percentage
        return ($id % 100) < $percentageAllowed;
    }

}