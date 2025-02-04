<?php

namespace App\Controller;

use App\Entity\Post;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/posts')]
class PostController extends AbstractController
{
    private PostService $postService;
    private SerializerInterface $serializer;

    public function __construct(PostService $postService, SerializerInterface $serializer)
    {
        $this->postService = $postService;
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'posts', methods: ['GET'])]
    public function getAllPosts(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
    
        $jsonData = $this->serializer->serialize(
            $posts,
            'json',
            [AbstractNormalizer::GROUPS => ['post:read']]
        );

        return new JsonResponse(['status' => 'success', 'data' => json_decode($jsonData)], JsonResponse::HTTP_OK);
    }


    #[Route('/create', name : 'post_create', methods: ['POST'])]
    public function createPost(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['title'], $data['content'])) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $post = $this->postService->createPost($data['title'], $data['content']);
        return $this->json($post, 201);
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function deletePost(int $id): JsonResponse
    {
        $this->postService->deletePost($id);
        return $this->json(['message' => 'Post deleted']);
    }
}
