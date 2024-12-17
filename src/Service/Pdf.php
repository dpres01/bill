<?php

namespace App\Service;

use App\Entity\Billed;
use DateTime;
use Exception;
use Spipu\Html2Pdf\Html2Pdf;
use Twig\Environment;

class Pdf
{
    public function __construct(private Environment $twig, private string $projectDir)
    {   
    }

    public function make(Billed $billed)
    {   
        $return = true;
        
        try{
            $dompdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(5, 10, 5, 10));

            //$dompdf->setTestIsImage(true);
            //$dompdf->addFont('thin', '', $this->projectDir.'/assets/fonts/Inter.ttf');
            $dompdf->setDefaultFont('courier');
            //$dompdf->setFallbackImage('/public/images/signature.png');
            $dompdf->writeHtml($this->twig->render('bill/invoice.html.twig', [
                'bill' => $billed,
                'startDate' => (new DateTime('first day of this month'))->format('d/m/Y'),
                'endDate' => (new DateTime('last day of this month'))->format('d/m/Y'),
            ]));

            $dompdf->output($billed->getRenter().'.pdf', 'D');
        } catch ( Exception $e) {
            $return = false;
        }

        return $return;
    }
}