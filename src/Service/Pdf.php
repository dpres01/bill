<?php

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;
use Twig\Environment;

class Pdf
{
    public function __construct(private Environment $twig)
    {   
    }

    public function make()
    {    
        $dompdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(5, 10, 5, 10));

        $dompdf->setTestIsImage(true);
        //$dompdf->setFallbackImage('/public/images/signature.png');
        $dompdf->writeHtml($this->twig->render('bill/invoice.html.twig', ['bill'=>0/*$bill*/]));

        $dompdf->output();
    }
}