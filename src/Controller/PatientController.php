<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    /**
     * @Route("/", name="patient_index", methods={"GET"})
     */
    public function index(UserRepository $patientRepository, RendezVousRepository $rendezVousRepository): Response
    {
        $user = $this->getUser();
        /*if($user->getRole() === "ROLE_MEDECIN"){

        }*/
        if($user->getRole() === "ROLE_SECRETAIRE"){
            $medecin = $user->getMedecin();
            $rdves = $rendezVousRepository->findBy(['medicin'=>$medecin]);
            $patients = [];
            foreach($rdves as $r){
                array_push($patients, $r->getPatient());
            }
            return $this->render('patient/index.html.twig', [
                'patients' => $patients,
            ]);
        }
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAllPatients(),
        ]);
    }

    /**
     * @Route("/new", name="patient_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $patient = new User();
        $form = $this->createForm(InscriptionType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $connected = $this->getUser();
            if($connected->getRole() === "ROLE_SECRETAIRE"){
                $hash = $encoder->encodePassword($patient, "00000000");
            }else{
                $hash = $encoder->encodePassword($patient, $patient->getPassword());
            }

            $patient->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_show", methods={"GET"})
     */
    public function show(User $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $patient, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(InscriptionType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($patient,$patient->getPassword());
            $patient->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_delete", methods={"POST"})
     */
    public function delete(Request $request, User $patient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patient_index');
    }
}
