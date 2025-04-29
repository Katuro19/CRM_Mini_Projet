<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class HelloWorldController extends AbstractController
{
    #[Route('/api/hello', name: 'api_hello', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        if($name == null){
            $name = "World";
        }
        return $this->json([
            'message' => "Hello {$name}!",
        ]);
    }
}