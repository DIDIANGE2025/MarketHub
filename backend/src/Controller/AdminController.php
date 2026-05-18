<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Service;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin')]
class AdminController extends AbstractController
{
    private function checkAdmin(): ?JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->json(['error' => 'Accès refusé'], 403);
        }
        return null;
    }

    // USERS
    #[Route('/users', name: 'admin_users', methods: ['GET'])]
    public function users(EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        $users = $em->getRepository(User::class)->findAll();
        $data = array_map(fn($u) => [
            'id' => $u->getId(),
            'email' => $u->getEmail(),
            'username' => $u->getUsername(),
            'roles' => $u->getRoles(),
            'createdAt' => $u->getCreatedAt()?->format('Y-m-d'),
        ], $users);

        return $this->json($data);
    }

    #[Route('/users/{id}', name: 'admin_delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id, EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        $user = $em->getRepository(User::class)->find($id);
        if (!$user) return $this->json(['error' => 'Utilisateur non trouvé'], 404);

        $em->remove($user);
        $em->flush();

        return $this->json(['message' => 'Utilisateur supprimé']);
    }

    // SERVICES
    #[Route('/services', name: 'admin_services', methods: ['GET'])]
    public function services(EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        $services = $em->getRepository(Service::class)->findAll();
        $data = array_map(fn($s) => [
            'id' => $s->getId(),
            'title' => $s->getTitle(),
            'price' => $s->getPrice(),
            'status' => $s->getStatus(),
            'seller' => $s->getSeller()->getUsername(),
        ], $services);

        return $this->json($data);
    }

    #[Route('/services/{id}', name: 'admin_delete_service', methods: ['DELETE'])]
    public function deleteService(int $id, EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        $service = $em->getRepository(Service::class)->find($id);
        if (!$service) return $this->json(['error' => 'Service non trouvé'], 404);

        $em->remove($service);
        $em->flush();

        return $this->json(['message' => 'Service supprimé']);
    }

    // ORDERS
    #[Route('/orders', name: 'admin_orders', methods: ['GET'])]
    public function orders(EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        $orders = $em->getRepository(Order::class)->findAll();
        $data = array_map(fn($o) => [
            'id' => $o->getId(),
            'status' => $o->getStatus(),
            'total' => $o->getTotal(),
            'buyer' => $o->getBuyer()->getUsername(),
            'service' => $o->getService()->getTitle(),
            'createdAt' => $o->getCreatedAt()?->format('Y-m-d'),
        ], $orders);

        return $this->json($data);
    }

    // STATS
    #[Route('/stats', name: 'admin_stats', methods: ['GET'])]
    public function stats(EntityManagerInterface $em): JsonResponse
    {
        if ($error = $this->checkAdmin()) return $error;

        return $this->json([
            'total_users' => count($em->getRepository(User::class)->findAll()),
            'total_services' => count($em->getRepository(Service::class)->findAll()),
            'total_orders' => count($em->getRepository(Order::class)->findAll()),
        ]);
    }
}