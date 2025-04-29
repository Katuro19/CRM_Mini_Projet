<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class DateAndTimeController extends AbstractController
{
    #[Route('/api/date', name: 'api_date', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {

        return $this->json([

            'timestamp' => new \DateTime()
        ]);
    }
}