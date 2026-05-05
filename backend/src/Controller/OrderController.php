<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/orders')]
class OrderController extends AbstractController
{
    #[Route('', name: 'order_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $data = json_decode($request->getContent(), true);

        if (!isset($data['service_id'])) {
            return $this->json(['error' => 'service_id requis'], 400);
        }

        $service = $em->getRepository(Service::class)->find($data['service_id']);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        $order = new Order();
        $order->setBuyer($this->getUser());
        $order->setService($service);
        $order->setTotal($service->getPrice());
        $order->setStatus('pending');

        $em->persist($order);
        $em->flush();

        return $this->json([
            'message' => 'Commande créée',
            'id' => $order->getId(),
            'status' => $order->getStatus(),
            'total' => $order->getTotal(),
        ], 201);
    }

    #[Route('/my', name: 'order_my', methods: ['GET'])]
    public function myOrders(EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $orders = $em->getRepository(Order::class)->findBy([
            'buyer' => $this->getUser()
        ]);

        $data = array_map(fn($o) => [
            'id' => $o->getId(),
            'status' => $o->getStatus(),
            'total' => $o->getTotal(),
            'service' => [
                'id' => $o->getService()->getId(),
                'title' => $o->getService()->getTitle(),
            ],
            'createdAt' => $o->getCreatedAt()->format('Y-m-d H:i:s'),
        ], $orders);

        return $this->json($data);
    }
}