<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BilledMaker;
use DateTime;
use Exception;
use Spipu\Html2Pdf\Html2Pdf;
use Twig\Environment;

class Pdf
{
    public function __construct(private Environment $twig, private string $projectDir)
    {   
    }

    public function make(BilledMaker $billedMaker)
    {   
        $return = true;
        
        try{
            $htmlToPdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(5, 10, 5, 10));

            //$dompdf->setTestIsImage(true);
            //$dompdf->addFont('thin', '', $this->projectDir.'/assets/fonts/Inter.ttf');
            //$dompdf->setFallbackImage('/public/images/signature.png');
            $htmlToPdf->setDefaultFont('courier');
            $htmlToPdf->writeHtml($this->twig->render('bill/invoice.html.twig', [
                'billed_maker' => $billedMaker,
                'startDate' => (new DateTime('first day of this month'))->format('d/m/Y'),
                'endDate' => (new DateTime('last day of this month'))->format('d/m/Y'),
            ]));
//dd($htmlToPdf);
            $htmlToPdf->output($billedMaker->getBilledRef()->getRenter().'.pdf');
        } catch ( Exception $e) {
            $return = false;
        }

        return $return;
    }
}