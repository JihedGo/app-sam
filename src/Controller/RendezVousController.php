<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\User;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rendez/vous")
 */
class RendezVousController extends AbstractController
{
    /**
     * @Route("/", name="rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $user = $this->getUser();
        $rdves = $rendezVousRepository->findAll();
        if($user->getRole() === "ROLE_MEDECIN"){
            $rdves = $user->getRendezVouses();
        }else if($user->getRole() == "ROLE_SECRETAIRE"){
            $rdves = $rendezVousRepository->findBy(['medicin'=>$user->getMedecin()]);
        }
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rdves,
        ]);
    }

    /**
     * @Route("/prendre-rdv/{id}", name="prendre_rdv", methods={"GET"})
     */
    public function prendreRendezVous(User $medecin,RendezVousRepository $rendezVousRepository): Response
    {
        $rdv = new RendezVous();

        $user = $this->getUser();
        $rdv->setPatient($user);
        $rdv->setMedicin($medecin);
        $rdv->setDateAt(new \DateTime());
        $rdv->setIsAccepted(false);
        $rdv->setIsTerminated(false);
        $rdv->setPriority(0);
        $this->getDoctrine()->getManager()->persist($rdv);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info',"Votre rendez-vous a été enregistré");
        return $this->redirectToRoute('mes_rendezvous');
    }

    /**
     * @Route("/mes-rendezvous", name="mes_rendezvous", methods={"GET"})
     */
    public function mesRendezVous(RendezVousRepository $rendezVousRepository): Response
    {
        $user = $this->getUser();
        $rdves = $rendezVousRepository->findBy(['patient'=>$user]);
        return $this->render('rendez_vous/mes-rendezvous.html.twig', [
            'rendez_vouses' => $rdves,
        ]);
    }

    /**
     * @Route("/new", name="rendez_vous_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVou->setDateAt(new \DateTime());
            $rendezVou->setIsTerminated(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendez_vous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RendezVous $rendezVou): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendez_vous_index');
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_delete", methods={"POST"})
     */
    public function delete(Request $request, RendezVous $rendezVou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendez_vous_index');
    }
}
