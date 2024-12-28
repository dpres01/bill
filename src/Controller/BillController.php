<?php

namespace App\Controller;

use App\Entity\Billed;
use App\Entity\BilledMaker;
use App\Form\BilledMakerType;
use App\Form\BilledType;
use App\Repository\BilledRepository;
use App\Service\Pdf;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    ): Response {

        if (!$billed) {
            $billed = new Billed();
        }

        $form = $this->createForm(BilledType::class, $billed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $em->persist($billed);
                $em->flush();
                
                $this->addFlash('success', "créée avec succès");
                
                return $this->redirectToRoute('app_home');
            } catch (Exception $e) {

                $this->addFlash('danger', "Une erreur est survenue");
            }
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
    ): Response {

        if (!$billed) {
            throw new HttpException(404, 'Ref billed not found!');
        }

        $billedMaker = (new BilledMaker())->setBilledRef($billed);

        $form = $this->createForm(BilledMakerType::class, $billedMaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($pdf->make($billedMaker)) {
                
                $this->addFlash('success', "La facture créée avec succès");

                return $this->redirectToRoute('app_home');
            }
            
            $this->addFlash('danger', "Une erreur est survenue");
        }

        return $this->render('bill/maker.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/bill/speed-generate/{id?<d+>}/{date?}', name: 'app_bill_speed_generate')]
    public function speedGenerate(?Billed $billed, ?DateTimeImmutable $date, Pdf $pdf): Response {
        
        $pdf->formatted($billed, $date);

        return $this->redirectToRoute('app_home');
    }

    #[Route('/bill/remove/{id?<d+>}', name: 'app_bill_remove')]
    public function delete(Billed $billed, EntityManagerInterface $em) 
    {
        $em->remove($billed);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}
