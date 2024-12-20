<?php

namespace App\Controller;

use App\Entity\Billed;
use App\Entity\BilledMaker;
use App\Form\BilledMakerType;
use App\Form\BilledType;
use App\Repository\BilledRepository;
use App\Service\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

class BillController extends AbstractController
{
    #[Route('/bill/list', name: 'app_bill_list')]
    public function index(BilledRepository $billRepo)
    {   
        return $this->render('bill/list.html.twig', [
            'bills' => $billRepo->findBills(),
        ]);
    }

    #[Route('/bill/edit/{id?<d+>}', name: 'app_bill_edit')]
    public function edit(
        Request $request,
        ?Billed $billed,
        EntityManagerInterface $em,
        Pdf $pdf
    ): Response {

        if (!$billed) {
            $billed = new Billed();
        }

        $form = $this->createForm(BilledType::class, $billed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($billed);
            $em->flush();

            $billedMaker = (new BilledMaker())->setBilledRef($billed);

            if ($pdf->make($billedMaker)) {
                $this->addFlash('success', "La facture de mois encours créée avec succès");

                return $this->render('bill/list.html.twig',[]);
            }

            $this->addFlash('error', "Une erreur est survenue");
        }

        return $this->render('bill/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/bill/generate/{id?<d+>}', name: 'app_bill_generate')]
    public function generate(
        Request $request,
        Billed $billed,
        Pdf $pdf
    ) {
        if (!$billed) {
            throw new HttpException(404, 'Ref billed not found!');
        }

        $billedMaker = (new BilledMaker())->setBilledRef($billed);

        $form = $this->createForm(BilledMakerType::class, $billedMaker);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($pdf->make($billedMaker)) {
                $this->addFlash('success', "La facture de mois encours créée avec succès");

                return $this->render('bill/list.html.twig',[]);
            }

            $this->addFlash('error', "Une erreur est survenue");
        }

        return $this->render('bill/maker.html.twig',[
            'form' => $form,
        ]);
    }
}
