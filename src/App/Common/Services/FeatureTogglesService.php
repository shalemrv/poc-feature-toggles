<?php

namespace App\Common\Services;

use App\FeatureTogglesBundle\Entity\FeatureFlag;

use Doctrine\ORM\EntityManager;


class FeatureTogglesService {

    private static $inMemFlags = [];

    private $em;

    private $creationTime;
    
    public function __construct(EntityManager $em) {

        $this->em = $em;
        
        $this->updateFlags();
        
        $this->creationTime = date('Y-m-d H:i:s');
    }

    public function getFlags() {
        return self::$inMemFlags;
    }

    public function updateFlags() {
        
        $featureFlags = $this->em->getRepository('FeatureTogglesBundle:FeatureFlag')->findAll();
        
        self::$inMemFlags = [];

        foreach ($featureFlags as $flag) {
            self::$inMemFlags[$flag->getName()] = [
                FeatureFlag::ID         => $flag->getId(),
                FeatureFlag::ACTIVE     => true,
                FeatureFlag::PERCENTAGE => $flag->getPercentage()
            ];
        }
    }

    public function isAllowed($flagName, $id = 0) {
        
        // If Flag does not exist
        if (!isset(self::$inMemFlags[$flagName]))
            return false;

        $flagDetails = self::$inMemFlags[$flagName];

        // If Flag is not active
        if (!$flagDetails['active'])
            return false;
    
        // If $id is in the allowed percentage
        return ($id % 100) < $flagDetails['percentage'];
    }

    public function getCreationTime() {
        return $this->creationTime;
    }

}