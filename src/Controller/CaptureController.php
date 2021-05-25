<?php

namespace App\Controller;

use App\Entity\CapteurMesurement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaptureController extends AbstractController
{
    /**
     * @Route("/getTemperateure", name="capture")
     */
    public function temperature(): Response
    {
       $temperature = $this->getDoctrine()->getRepository(CapteurMesurement::class)->findAll();
       return new JsonResponse(['temperatures'=>$temperature]);
    }

      /**
     * @Route("/getCoeurs", name="capture")
     */
    public function coeurs(): Response
    {
       $temperature = $this->getDoctrine()->getRepository(CapteurMesurement::class)->findAll();
       return new JsonResponse(['temperatures'=>$temperature]);
    }
}
