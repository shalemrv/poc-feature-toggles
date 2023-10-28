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
        
        $this->creationTime = date('Y-m-d H:i:s');
    }

    public function getFlags() {
        return $this->flags;
    }

    public function updateFlags() {
        
        $featureFlags = $this->em->getRepository(FeatureFlag::class)->findAll();
        
        $this->flags = [];

        foreach ($featureFlags as $flag) {
            $this->flags[$flag->getName()] = [
                FeatureFlag::ID         => $flag->getId(),
                FeatureFlag::ACTIVE     => true,
                FeatureFlag::PERCENTAGE => $flag->getPercentage()
            ];
        }
    }

    public function isAllowed($flagName, $id = 0) {
        
        // If Flag does not exist
        if (!isset($this->flags[$flagName]))
            return false;

        $flagDetails = $this->flags[$flagName];

        // If Flag is not active
        if (!$flagDetails[FeatureFlag::ACTIVE])
            return false;
    
        // If $id is in the allowed percentage
        return ($id % 100) < $flagDetails[FeatureFlag::PERCENTAGE];
    }

}