<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceRow;
use App\Form\InvoicesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{

    /**
     * @Route("/invoices/add", name="invoice_add")
     */
    public function add(Request $request)
    {
        $IVA_AMOUNT = 22.20;

        $invoice = new Invoice();
        $invoiceRow = new InvoiceRow();

        $invoice->setNInvoice(0);
        $invoiceRow->setAmount(0);
        $invoiceRow->setAmountIva(0);
        $invoiceRow->setTotalAmountWithIva(0);
        $invoiceRow->setDescription("");
        $invoiceRow->setQuantity(0);
        $invoiceRow->setInvoice($invoice);


        $form = $this->createForm(InvoicesFormType::class, $invoiceRow);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $invoice->setDateCreated(new \DateTime());
            $invoice->setNInvoice(random_int(10, 1000));
            $invoice->setInvoiceRow($invoiceRow);
            $invoice->setCustomerID(random_int(10,1000));

            $invoiceRow = $form->getData();

//            $totalAmountWithIva = $this->$form->get("TotalAmountWithIva");
            $amountIva = floatval($invoiceRow->getTotalAmountWithIva()) * $IVA_AMOUNT = 22.2 / 100;
            $amount = floatval($invoiceRow->getTotalAmountWithIva())- $amountIva;

            $invoiceRow->setAmountIva($amountIva);
            $invoiceRow->setAmount($amount);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoice);
            $entityManager->persist($invoiceRow);
            $entityManager->flush();


            return $this->render("/invoiceAdded/invoices.html.twig" , array("rowInserted" => $invoiceRow ) ) ;

        }
            return $this->render('invoice/newInvoice.html.twig', [
            'form' => $form->createView(),
        ]);


    }


    /**
     * @Route("/invoices/see/{@id}", name="see_invoice")
     */
    public function seeInvoice($id){



    }

}
