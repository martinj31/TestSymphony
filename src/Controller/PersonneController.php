<?php

namespace App\Controller;


use Doctrine\DBAL\Types\DateType;
use \App\Entity\Personne;
use App\Form\PersonneFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(PersonneFormType::class);
        $form->handleRequest($request);    



        $allPersonne = $em->getRepository(Personne::class)->findAll();



        if($form->isSubmitted() && $form->isValid()){


            $personne = new Personne($form);

            
            $personne->setNom($form->get("nom")->getData());
            $personne->setPrenom($form->get("prenom")->getData());
            $personne->setDateNaissance($form->get("dateNaissance")->getData());

            $em->persist($personne);
            $em->flush();

        }

        return $this->render('personne/index.html.twig', [
            'form_Personne' => $form->createView(),
            'allPersonne' => $allPersonne
        ]);
    }
}
