<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/hello", methods={"GET"})
     *
     * @OA\Get(
     *     path="/api/hello",
     *     summary="Dire bonjour",
     *     @OA\Response(
     *         response=200,
     *         description="Message de bienvenue"
     *     )
     * )
     */
    public function hello(): JsonResponse
    {
        return $this->json(['message' => 'Salut ! Bienvenue sur mon API 😊']);
    }
}
