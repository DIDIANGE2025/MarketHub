<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Order;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/reviews')]
class ReviewController extends AbstractController
{
    #[Route('', name: 'review_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $data = json_decode($request->getContent(), true);

        if (!isset($data['service_id'], $data['order_id'], $data['rating'])) {
            return $this->json(['error' => 'service_id, order_id et rating requis'], 400);
        }

        if ($data['rating'] < 1 || $data['rating'] > 5) {
            return $this->json(['error' => 'rating doit être entre 1 et 5'], 400);
        }

        $service = $em->getRepository(Service::class)->find($data['service_id']);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        $order = $em->getRepository(Order::class)->find($data['order_id']);
        if (!$order) {
            return $this->json(['error' => 'Commande non trouvée'], 404);
        }

        $review = new Review();
        $review->setBuyer($this->getUser());
        $review->setService($service);
        $review->setOrder($order);
        $review->setRating($data['rating']);
        $review->setComment($data['comment'] ?? null);

        $em->persist($review);
        $em->flush();

        return $this->json([
            'message' => 'Avis créé',
            'id' => $review->getId(),
            'rating' => $review->getRating(),
        ], 201);
    }

    #[Route('/service/{id}', name: 'review_by_service', methods: ['GET'])]
    public function byService(int $id, EntityManagerInterface $em): JsonResponse
    {
        $service = $em->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        $reviews = $em->getRepository(Review::class)->findBy(['service' => $service]);

        $data = array_map(fn($r) => [
            'id' => $r->getId(),
            'rating' => $r->getRating(),
            'comment' => $r->getComment(),
            'buyer' => $r->getBuyer()->getUsername(),
            'createdAt' => $r->getCreatedAt()->format('Y-m-d H:i:s'),
        ], $reviews);

        return $this->json($data);
    }
}