<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\User;
use App\Form\DossierType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/medecin")
 */
class MedecinController extends AbstractController
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
     /**
     * @Route("/", name="medecin_index", methods={"GET"})
     */
    public function medecins(UserRepository $userRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'users' => $userRepository->findAllMedecins(),
        ]);
    }
/**
     * @Route("/consultations/", name="doctor_consultation")
     */
    public function mesconsultations(){
        $doctor = $this->getUser();
      $consultations = $this->getDoctrine()->getRepository(RendezVous::class)->findBy(['medicin'=>$doctor]);
      return $this->render('medecin/consultations.html.twig',['rendez_vouses'=>$consultations]);
    }
    /**
     * @Route("/consulter/{id}",name="consulter_dossier")
     */
    public function consulter(User $patient,Request $request){

        $dossier = new Dossier();
        $dossier->setPatient($patient);
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('dossier_index');
        }

        return $this->render('dossier/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new", name="medecin_new", methods={"GET","POST"})
     */
    public function newMedecin(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $this->encoder->encodePassword($user, "00000000");
            $user->setRole('ROLE_MEDECIN');
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('medecin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medecin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medecin_index');
    }


}
