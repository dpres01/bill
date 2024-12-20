<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person/edit/{id?<d+>}', name: 'app_person_edit')]
    public function edit(
        Request $request,
        ?Person $person,
        EntityManagerInterface $em
    ): Response {

        if (!$person) {
            $person = new Person();
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($person);
            $em->flush();
        }

        return $this->render('person/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/person/list', name: 'app_person_list')]
    public function list(PersonRepository $personRepo)
    {
        return $this->render('person/list.html.twig', [
            'persons' => $personRepo->findOccupants(),
        ]);
    }

    #[Route('/person/remove/{id}', name: 'app_person_remove')]
    public function remove(Person $person)
    {
        dd($person);

        return $this->redirect('app_person_list');
    }

}
