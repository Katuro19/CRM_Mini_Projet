<?php

namespace App\Controller;

use App\Entity\Recruiter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/recruiters')]
class RecruiterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Liste tous les recruteurs
    #[Route('', name: 'app_recruiter_index', methods: ['GET'])]
    public function index(): JsonResponse
    {


        $recruiters = $this->entityManager->getRepository(Recruiter::class)->findAll();
        
        $data = [];
        foreach ($recruiters as $recruiter) {
            $data[] = [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName(),
                'company' => $recruiter->getCompany(),
                'email' => $recruiter->getEmail(),
                'linkedinProfile' => $recruiter->getLinkedinProfile(),
                'phone' => $recruiter->getPhone(),
                'status' => $recruiter->getStatus(),
                'notes' => $recruiter->getNotes(),
                'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
            ];
        }
        
        return new JsonResponse($data);
    }

    // Récupère un recruteur par son ID
    #[Route('/{id}', name: 'app_recruiter_show', methods: ['GET'])]
    public function show(Recruiter $recruiter): JsonResponse
    {

        $data = [
            'id' => $recruiter->getId(),
            'firstName' => $recruiter->getFirstName(),
            'lastName' => $recruiter->getLastName(),
            'company' => $recruiter->getCompany(),
            'email' => $recruiter->getEmail(),
            'linkedinProfile' => $recruiter->getLinkedinProfile(),
            'phone' => $recruiter->getPhone(),
            'status' => $recruiter->getStatus(),
            'notes' => $recruiter->getNotes(),
            'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
        
        return new JsonResponse($data);
    }

    // Dans la méthode create du RecruiterController
    #[Route('', name: 'app_recruiter_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {

        if (!$this->checkKey($request)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        try {
            $data = json_decode($request->getContent(), true);
            // Vérification des champs obligatoires
            if (!isset($data['firstName']) || !isset($data['lastName']) || !isset($data['email'])) {
                return new JsonResponse(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
            }

            $recruiter = new Recruiter();
            // ... configuration du recruteur
            $recruiter->setFirstName($data['firstName']);
            $recruiter->setLastName($data['lastName']);
            $recruiter->setCompany($data['company']);
            $recruiter->setLinkedinProfile($data['linkedinProfile']);
            $recruiter->setEmail($data['email']);
            $recruiter->setPhone($data['phone'] ?? null);
            $recruiter->setStatus($data['status']);
            $recruiter->setNotes($data['notes'] ?? null);
            $recruiter->setCreatedAt(new \DateTimeImmutable());
            $recruiter->setUpdatedAt(new \DateTimeImmutable());


            $this->entityManager->persist($recruiter);
            $this->entityManager->flush();

            $responseData = [
                'id' => $recruiter->getId(),
                'firstName' => $recruiter->getFirstName(),
                'lastName' => $recruiter->getLastName(),
                'company' => $recruiter->getCompany(),
                'email' => $recruiter->getEmail(),
                'linkedinProfile' => $recruiter->getLinkedinProfile(),
                'phone' => $recruiter->getPhone(),
                'status' => $recruiter->getStatus(),
                'notes' => $recruiter->getNotes(),
                'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            // ... création de la réponse
            
            return new JsonResponse($responseData, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Met à jour un recruteur existant
    #[Route('/{id}', name: 'app_recruiter_update', methods: ['PUT'])]
    public function update(Request $request, Recruiter $recruiter): JsonResponse
    {

        if (!$this->checkKey($request)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->getContent(), true);
        
        if (isset($data['firstName'])) {
            $recruiter->setFirstName($data['firstName']);
        }
        if (isset($data['lastName'])) {
            $recruiter->setLastName($data['lastName']);
        }
        if (isset($data['company'])) {
            $recruiter->setCompany($data['company']);
        }
        if (isset($data['linkedinProfile'])) {
            $recruiter->setLinkedinProfile($data['linkedinProfile']);
        }
        if (isset($data['email'])) {
            $recruiter->setEmail($data['email']);
        }
        if (isset($data['phone'])) {
            $recruiter->setPhone($data['phone']);
        }
        if (isset($data['status'])) {
            $recruiter->setStatus($data['status']);
        }
        if (isset($data['notes'])) {
            $recruiter->setNotes($data['notes']);
        }
        
        $recruiter->setUpdatedAt(new \DateTimeImmutable());
        
        $this->entityManager->flush();
        
        $responseData = [
            'id' => $recruiter->getId(),
            'firstName' => $recruiter->getFirstName(),
            'lastName' => $recruiter->getLastName(),
            'company' => $recruiter->getCompany(),
            'email' => $recruiter->getEmail(),
            'linkedinProfile' => $recruiter->getLinkedinProfile(),
            'phone' => $recruiter->getPhone(),
            'status' => $recruiter->getStatus(),
            'notes' => $recruiter->getNotes(),
            'createdAt' => $recruiter->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $recruiter->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
        
        return new JsonResponse($responseData);
    }

    // Supprime un recruteur
    #[Route('/{id}', name: 'app_recruiter_delete', methods: ['DELETE'])]
    public function delete(Recruiter $recruiter): JsonResponse
    {


        $this->entityManager->remove($recruiter);
        $this->entityManager->flush();
        
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function checkKey(Request $request): bool
    {
        // 1. Clé attendue (tu peux aussi la stocker dans .env)
        $expectedKey = $this->getParameter('api_key');

        // 2. Récupération de la clé dans le header Authorization ou en GET
        $apiKey = $request->headers->get('X-API-KEY'); // Ex: dans Postman tu mets un header X-API-KEY
        // Ou en GET : ?apiKey=blabla
        if (!$apiKey) {
            $apiKey = $request->query->get('apiKey');
        }

        // 3. Comparaison
        return $apiKey === $expectedKey;
    }


    

}