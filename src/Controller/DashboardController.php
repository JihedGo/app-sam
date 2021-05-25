<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends AbstractController
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {   
        $this->encoder = $encoder;
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'patients' => count($this->getDoctrine()->getRepository(Patient::class)->findAll()),
            'medecins' => count($this->getDoctrine()->getRepository(User::class)->findAllMedecins()),
            'secretaires' => count($this->getDoctrine()->getRepository(User::class)->findAllSecretaires()),
        ]);
    }
    
}
