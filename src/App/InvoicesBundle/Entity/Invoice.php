<?php

namespace App\InvoicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTime;

use App\ProjectsBundle\Entity\Project;

/**
 * Invoice
 *
 * @ORM\Table(name="invoices")
 * @ORM\Entity(repositoryClass="App\InvoicesBundle\Repository\InvoiceRepository")
 */
class Invoice
{
    const ID                = 'id';
    const INVOICE_NUMBER    = 'invoice_number';
    const DATE              = 'date';
    const PAYMENT_STATUS    = 'payment_status';
    const COMMENTS          = 'comments';
    const PROJECT           = 'project';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="App\ProjectsBundle\Entity\Project")
     * @ORM\JoinColumn(onDelete="Cascade")
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_number", type="string", length=255, unique=true)
     */
    private $invoiceNumber;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;


    //  * @ORM\Column(name="payment_status", type="string", columnDefinition="enum('UNPAID', 'PARTIALLY_PAID', 'PAID')")

    /**
     * @var string
     *
     * @ORM\Column(name="payment_status", type="string", length=30, options={"default" : "UNPAID"})
     */
    private $paymentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;


    public function __construct()
    {
        $this->paymentStatus = 'UNPAID';
        $this->setDate();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set Project
     * 
     * @param Project $project
     *
     * @return Invoice
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get id
     *
     * @return number
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set Amount
     * 
     * @param number $amount
     *
     * @return number
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }


    /**
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     *
     * @return Invoice
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set invoiceNumber
     *
     * @param string $date
     *
     * @return Invoice
     */
    public function setDate($date = null)
    {
        $this->date = $date ? new DateTime($date) : new DateTime();

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     *
     * @return Invoice
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Invoice
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get Plain date time string
     *
     * @param \DateTime $date
     *
     * @return string
     */
    private function formateDate(\DateTime $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get description
     *
     * @return array
     */
    public function toArray($withProject = true)
    {
        $invoiceArray = [
            self::ID                => $this->id,
            self::INVOICE_NUMBER    => $this->invoiceNumber,
            self::DATE              => $this->date->format('Y-m-d'),
            self::PAYMENT_STATUS    => $this->paymentStatus,
            self::COMMENTS          => $this->comments
        ];
        
        if ($withProject)
            $invoiceArray[self::PROJECT] = $this->project->toArray();
  
        return $invoiceArray;
    }
}
