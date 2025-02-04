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
    
        if (!$posts) {
            $jsonData = $this->serializer->serialize(
                $posts,
                'json',
                [AbstractNormalizer::GROUPS => ['post:read']]
            );
    
            return new JsonResponse(['status' => 'success', 'data' => json_decode($jsonData)], JsonResponse::HTTP_OK);
        }
    
        // Используем Symfony Serializer для конвертации объектов в JSON
        $jsonPosts = $serializer->serialize($posts, 'json', ['groups' => 'post:read']);
    
        return new JsonResponse([
            'status' => 'success',
            'data' => json_decode($jsonPosts, true)
        ], JsonResponse::HTTP_OK);
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
    public function deletePost(Post $post): JsonResponse
    {
        $this->postService->deletePost($post);
        return $this->json(['message' => 'Post deleted']);
    }
}
