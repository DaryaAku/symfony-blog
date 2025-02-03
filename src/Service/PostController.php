<?php

namespace App\Controller;

use App\Entity\Post;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/posts')]
class PostController extends AbstractController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    #[Route('/', methods: ['GET'])]
    public function getAllPosts(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        return $this->json($posts);
    }

    #[Route('/create', methods: ['POST'])]
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
