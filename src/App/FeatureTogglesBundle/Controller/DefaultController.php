<?php

namespace App\FeatureTogglesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use App\Common\Traits\HttpRequestTrait;
use App\Common\Services\FeatureTogglesService;
use App\Common\Services\ServicesList;
use App\FeatureTogglesBundle\Entity\FeatureFlag;

/**
 * Featureflag controller.
 *
 * @Route("feature-toggles")
 */
class DefaultController extends Controller
{
    use HttpRequestTrait;

    private function setFeatureFlagDetails(FeatureFlag &$featureFlag, $featureFlagDetails) {
        $featureFlag->setName($featureFlagDetails[FeatureFlag::NAME]);
        $featureFlag->setActive(!!$featureFlagDetails[FeatureFlag::ACTIVE]);
        $featureFlag->setPercentage(intval($featureFlagDetails[FeatureFlag::PERCENTAGE]));
    }

    private function extractAndSetFeatureFlagDetails(Request $request, FeatureFlag &$featureFlag) {
        $featureFlagDetails =   $this->extractDataFromRequest(
                                    $request, [
                                        FeatureFlag::NAME,
                                        FeatureFlag::ACTIVE,
                                        FeatureFlag::PERCENTAGE,
                                    ]
                                );
        
        $this->setFeatureFlagDetails($featureFlag, $featureFlagDetails);
    }

    /**
     * Lists all featureFlag entities.
     *
     * @Route("/test", name="feauture-toggles_test")
     * @Method("GET")
     */
    public function testAction()
    {
        $flags = $this->get(ServicesList::FEATURE_TOGGLES)->getFlags();

        echo json_encode($flags);

        foreach($flags as $flagName => $flag) {
            echo "\n\n";
            
            $allowed = 0;
            $denied = 0;

            for ($id = 1; $id <= 100; $id++) {
                $isAllowed = $this->get(ServicesList::FEATURE_TOGGLES)->isAllowed($flagName, $id);

                if ($isAllowed) {
                    $allowed++;
                    echo "\n$flagName - $id - ALLOWED";
                }
                else {
                    $denied++;
                    echo "\n$flagName - $id - DENIED";
                }
            }

            echo "\n\n$flagName\n\tALLOWED = $allowed\n\tDENIED = $denied\n\n";
        }

        return new JsonResponse();
    }

    /**
     * Lists all featureFlag entities.
     *
     * @Route("", name="feauture-toggles_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $featureFlags = $em->getRepository(FeatureFlag::class)->findAll();
        
        $featureFlagsJson = [];

        foreach ($featureFlags as $featureFlag)
            $featureFlagsJson[] = $featureFlag->toArray();
        
        return new JsonResponse($featureFlagsJson);
    }

    /**
     * Creates a new featureFlag entity.
     *
     * @Route("", name="feauture-toggles_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $featureFlag = new FeatureFlag();
        
        $this->extractAndSetFeatureFlagDetails($request, $featureFlag);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($featureFlag);

        $em->flush();

        return new JsonResponse($featureFlag->toArray());
    }
    
    /**
     * Displays a form to edit an existing featureFlag entity.
     *
     * @Route("/{id}", name="feauture-toggles_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, FeatureFlag $featureFlag)
    {

        $this->extractAndSetFeatureFlagDetails($request, $featureFlag);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->flush();

        return new JsonResponse($featureFlag->toArray());
    }

    /**
     * Deletes a featureFlag entity.
     *
     * @Route("/{id}", name="feauture-toggles_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FeatureFlag $featureFlag)
    {

        $id = $featureFlag->getId();
        $name = $featureFlag->getName();

        $em = $this->getDoctrine()->getManager();

        $em->remove($featureFlag);

        $em->flush();

        return new JsonResponse([
            "message" => "Successfully deleted Feature Flag - $id - $name"
        ]);
    }
}
