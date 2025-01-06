<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Billed;
use App\Entity\BilledMaker;
use DateTimeImmutable;
use Exception;
use Spipu\Html2Pdf\Html2Pdf;
use Twig\Environment;

class Pdf
{
    public function __construct(private Environment $twig, private string $projectDir)
    {   
    }

    public function make(BilledMaker $billedMaker): bool
    {   
        $return = true;
        
        try{
            $htmlToPdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(5, 10, 5, 10));

            //$dompdf->setTestIsImage(true);
            //$htmlToPdf->addFont('thin', 'regular', $this->projectDir.'/assets/fonts/roboto-light.ttf');
            //$htmlToPdf->setDefaultFont('dejavusansmono');
            $htmlToPdf->setDefaultFont('pdfacourier');

            $htmlToPdf->writeHtml($this->twig->render('bill/invoice.html.twig', [
                'billed_maker' => $billedMaker,
            ]));
            
            $htmlToPdf->output($billedMaker->getBilledRef()->getRenter().'.pdf', 'D');
        } catch ( Exception $e) {
            $return = false;    
        }

        return $return;
    }

    public function formatted(Billed $billed, DateTimeImmutable $date): bool
    {   
        $billedMaker = new BilledMaker();
        $startDate = $date->modify(BilledMaker::FIRST_DAY);

        $billedMaker->setBilledRef($billed)
            ->setPaymentAt($startDate->modify(BilledMaker::PAYMENT_AT))
            ->setEndAtPeriod($date->modify(BilledMaker::LAST_DAY))
            ->setStartAtPeriod($startDate);

        return $this->make($billedMaker);
    }
}