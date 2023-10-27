<?php

namespace App\InvoicesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Invoice controller.
 *
 * @Route("invoices")
 */
class DefaultController extends Controller
{
    /**
     * Lists all invoice entities.
     *
     * @Route("", name="invoice_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $invoices = $em->getRepository('InvoicesBundle:Invoice')->findAll();

        $invoicesJson = [];

        foreach ($invoices as $invoice)
            $invoicesJson[] = $invoice->toArray();
        
        return new JsonResponse($invoicesJson);
    }
}
