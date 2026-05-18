<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/services')]
class ServiceController extends AbstractController
{
    #[Route('', name: 'services_list', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $qb = $em->getRepository(Service::class)->createQueryBuilder('s')
            ->leftJoin('s.seller', 'u')
            ->leftJoin('s.category', 'c')
            ->addSelect('u', 'c')
            ->where('s.status = :status')
            ->setParameter('status', 'active');

        if ($search = $request->query->get('q')) {
            $qb->andWhere('s.title LIKE :search OR s.description LIKE :search')
               ->setParameter('search', '%'.$search.'%');
        }

        if ($category = $request->query->get('category')) {
            $qb->andWhere('c.slug = :category')
               ->setParameter('category', $category);
        }

        if ($maxPrice = $request->query->get('max_price')) {
            $qb->andWhere('s.price <= :maxPrice')
               ->setParameter('maxPrice', $maxPrice);
        }

        $services = $qb->getQuery()->getResult();

        $data = array_map(fn($s) => [
            'id' => $s->getId(),
            'title' => $s->getTitle(),
            'description' => $s->getDescription(),
            'price' => $s->getPrice(),
            'status' => $s->getStatus(),
            'seller' => [
                'id' => $s->getSeller()->getId(),
                'username' => $s->getSeller()->getUsername(),
            ],
            'category' => $s->getCategory() ? [
                'id' => $s->getCategory()->getId(),
                'name' => $s->getCategory()->getName(),
            ] : null,
        ], $services);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'service_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): JsonResponse
    {
        $service = $em->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        return $this->json([
            'id' => $service->getId(),
            'title' => $service->getTitle(),
            'description' => $service->getDescription(),
            'price' => $service->getPrice(),
            'status' => $service->getStatus(),
            'seller' => [
                'id' => $service->getSeller()->getId(),
                'username' => $service->getSeller()->getUsername(),
            ],
            'category' => $service->getCategory() ? [
                'id' => $service->getCategory()->getId(),
                'name' => $service->getCategory()->getName(),
            ] : null,
            'createdAt' => $service->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('', name: 'service_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'], $data['price'])) {
            return $this->json(['error' => 'title et price requis'], 400);
        }

        $service = new Service();
        $service->setSeller($this->getUser());
        $service->setTitle($data['title']);
        $service->setDescription($data['description'] ?? '');
        $service->setPrice($data['price']);

        if (isset($data['category_id'])) {
            $category = $em->getRepository(Category::class)->find($data['category_id']);
            if ($category) $service->setCategory($category);
        }

        $em->persist($service);
        $em->flush();

        return $this->json([
            'message' => 'Service créé',
            'id' => $service->getId()
        ], 201);
    }

    #[Route('/{id}', name: 'service_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $service = $em->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        if ($service->getSeller()->getId() !== $this->getUser()->getId()) {
            return $this->json(['error' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) $service->setTitle($data['title']);
        if (isset($data['description'])) $service->setDescription($data['description']);
        if (isset($data['price'])) $service->setPrice($data['price']);
        if (isset($data['status'])) $service->setStatus($data['status']);

        if (isset($data['category_id'])) {
            $category = $em->getRepository(Category::class)->find($data['category_id']);
            if ($category) $service->setCategory($category);
        }

        $em->flush();

        return $this->json([
            'message' => 'Service mis à jour',
            'id' => $service->getId()
        ]);
    }

    #[Route('/{id}', name: 'service_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $service = $em->getRepository(Service::class)->find($id);
        if (!$service) {
            return $this->json(['error' => 'Service non trouvé'], 404);
        }

        if ($service->getSeller()->getId() !== $this->getUser()->getId()) {
            return $this->json(['error' => 'Accès refusé'], 403);
        }

        $em->remove($service);
        $em->flush();

        return $this->json(['message' => 'Service supprimé']);
    }
}