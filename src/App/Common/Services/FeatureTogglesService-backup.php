<?php

namespace App\Common\Services;

use App\FeatureTogglesBundle\Entity\FeatureFlag;


class FeatureTogglesService {

    private static $instance = null;
    
    private $creationTime;

    private $flags = [];

    private function __construct($em) {
        $featureFlags = $em->getRepository('FeatureTogglesBundle:FeatureFlag')->findAll();
        
        $featureFlagsJson = [];

        foreach ($featureFlags as $featureFlag)
            $featureFlagsJson[] = $featureFlag->toArray();
        
        exit(json_encode(["FeatureTogglesService", $featureFlagsJson]));

        $this->creationTime = date('Y-m-d H:i:s');
    }
    
    private static function instantiate() {
        
        if (self::$instance !== null)
            return;
        
        self::$instance = new FeatureTogglesService();
    }

    private function persistFlags() {
        // Data Persistence
        $flags = [
            [
                'id' => 1,
                'name' => 'INVOICE_GENERATION_MICROSERVICE',
                'active' => true,
                'percentage' => 30
            ],
            [
                'id' => 2,
                'name' => 'TASK_MANAGEMENT_MICROSERVICE',
                'active' => true,
                'percentage' => 75
            ]
        ];

        $this->flags = [];

        foreach($flags as $flag) {
            $this->flags[$flag['name']] = [
                'active'        => $flag['active'],
                'percentage'    => $flag['percentage']
            ];
        }
    }


    // PUBLIC FACING FUNCTIONS THAT USERS CAN CALL

    public static function updateFlags() {

        self::instantiate();

        self::$instance->persistFlags();

        return self::$instance->flags;

    }

    public static function isEnabledAndAllowed($flagName, $id = 0) {
        self::instantiate();
        
        // If Flag does not exist
        if (!isset(self::$instance->flags[$flagName]))
            return false;

        $flagDetails = self::$instance->flags[$flagName];

        // If Flag is not active
        if (!$flagDetails['active'])
            return false;

    
        // If $id is in the allowed percentage
        return ($id % 100) < $flagDetails['percentage'];
    }

    public static function getCreationTime() {
        self::instantiate();

        return self::$instance->creationTime;
    }

}