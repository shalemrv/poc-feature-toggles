<?php

namespace App\ProjectsBundle\Controller;

use Doctrine\ORM\EntityManager;
use App\Common\Services\ServicesList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use App\ProjectsBundle\Entity\Project;
use App\InvoicesBundle\Entity\Invoice;
use App\FeatureTogglesBundle\Entity\FeatureFlag;

use App\Common\Traits\HttpRequestTrait;

/**
 * Project controller.
 *
 * @Route("projects")
 */
class DefaultController extends Controller
{
    use HttpRequestTrait;

    private function createInvoiceThroughMicroservice(Project &$project) {
        // Microservice called here
        return [
            "message" => "Invoice Microservice called"
        ];
    }

    private function createInvoiceForProject(EntityManager &$em, Project $project) {

        $featureTogglesService = $this->get(ServicesList::FEATURE_TOGGLES);

        $mustGoThroughInvoiceMicroservice = $featureTogglesService->isAllowed(
                                                FeatureFlag::INVOICE_GENERATION_MICROSERVICE,
                                                $project->getId()
                                            );  
        
        if($mustGoThroughInvoiceMicroservice)
            return $this->createInvoiceThroughMicroservice($project);

        $invoice = new Invoice();
        
        $invoice->setProject($project);
        $invoice->setInvoiceNumber(rand(10000,99999));
        $invoice->setAmount(rand(100000,999999) / 100);
        $invoice->setDate($project->getEndTime()->format('Y-m-d'));
        
        $em->persist($invoice);

        $em->flush();

        return $invoice->toArray(false);
    }
    
    private function setProjectDetails(Project &$project, $projectDetails) {
        $project->setName($projectDetails['name'] . ' - ' . rand(100, 999));
        $project->setDescription($projectDetails['description']);
        $project->setStartTime($projectDetails['start']);
        $project->setEndTime($projectDetails['end']);
    }

    private function extractAndSetProjectDetails(Request $request, Project &$project) {
        
        $projectDetails =   $this->extractDataFromRequest(
                                $request, [
                                    Project::NAME,
                                    Project::DESCRIPTION,
                                    Project::START,
                                    Project::END
                                ]
                            );

        $this->setProjectDetails($project, $projectDetails);
    }

    /**
     * Lists all project entities.
     *
     * @Route("", name="project_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $projects = $em->getRepository(Project::class)->findAll();
        
        $projectsJson = [];

        foreach ($projects as $project)
            $projectsJson[] = $project->toArray();
        
        return new JsonResponse($projectsJson);
    }

    /**
     * Creates a new project entity.
     *
     * @Route("", name="project_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        
        $this->extractAndSetProjectDetails($request, $project);
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($project);

        $em->flush();
        
        $invoice = $this->createInvoiceForProject($em, $project);

        $result = $project->toArray();

        $result[Project::INVOICE] = $invoice;

        return new JsonResponse($result); 
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{id}", name="project_show")
     * @Method("GET")
     */
    public function showAction(Project $project)
    {
        return new JsonResponse($project->toArray());
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{id}", name="project_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, Project $project)
    {
        $this->extractAndSetProjectDetails($request, $project);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->flush();

        return new JsonResponse($project->toArray());
    }

    /**
     * Deletes a project entity.
     *
     * @Route("/{id}", name="project_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Project $project)
    {
        $id = $project->getId();
        $name = $project->getName();

        $em = $this->getDoctrine()->getManager();

        $em->remove($project);

        $em->flush();

        return new JsonResponse([
            "message" => "Successfully deleted Project - $id - $name"
        ]);
    }
}
