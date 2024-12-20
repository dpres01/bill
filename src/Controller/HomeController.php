<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\BilledRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, BilledRepository $billedRepo): Response
    {

        return $this->render('home/index.html.twig', [
            'bills' => $billedRepo->findAll(),
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_panier_add')]
    public function addPanier(Request $request, Person $person, SerializerInterface $serializer)
    {
        $session = $request->getSession();
        //$session->clear();
        $panier[] = $person;
        if ($panierSession = $session->get('panier')) {
            $p = $serializer->deserialize($panierSession, Person::class.'[]', 'json');
            $exist = false;

            foreach($p as $k) {
                if ($k->getId() === $person->getId()) {
                    $exist = true;
                }
            }
            
            if (!$exist) {
                $panier = array_merge($p, $panier); 
            } else {
                $panier = $p;
            }
        }

        $session->set('panier', $serializer->serialize($panier,'json'));
        
        return $this->render('home/panier.html.twig', [
            'persons' => $serializer->deserialize($session->get('panier'), Person::class.'[]', 'json')
        ]);
    }
}   