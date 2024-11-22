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
        dd($pdf->make($billRepo->findAll()));
        dd($billRepo->findAll());
    }

    #[Route('/bill/edit', name: 'app_bill_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BilledType::class, new Billed());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
        }

        return $this->render('bill/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
