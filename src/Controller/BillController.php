<?php

namespace App\Controller;

use App\Entity\Billed;
use App\Form\BilledType;
use App\Repository\BilledRepository;
use App\Service\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BillController extends AbstractController
{
    #[Route('/bill/list', name: 'app_bill_list')]
    public function index(BilledRepository $billRepo, Pdf $pdf)
    {   
        //dd(new DateTime('last day of this month'));
        //dd($pdf->make($billRepo->find(1)));
        dd($billRepo->findAll());
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

            if ($pdf->make($billed)) {
                $this->addFlash('success', "La facture de mois encours créée avec succès");

                return $this->render('bill/list.html.twig',[]);
            }

            $this->addFlash('error', "Une erreur est survenue");
        }

        return $this->render('bill/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/bill/generate', name: 'app_bill_generate')]
    public function generate()
    {
        dd('ici');

        if ($pdf->make($billed)) {
            $this->addFlash('success', "La facture de mois encours créée avec succès");

            return $this->render('bill/list.html.twig',[]);
        }

        $this->addFlash('error', "Une erreur est survenue");

    }
}
