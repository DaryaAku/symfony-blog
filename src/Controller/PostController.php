<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Service\ApiFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/posts')]
class PostController extends AbstractController
{
    private PostRepository $postRepository;
    private ApiFormatter $apiFormatter;

    public function __construct(PostRepository $postRepository, ApiFormatter $apiFormatter)
    {
        $this->postRepository = $postRepository;
        $this->apiFormatter = $apiFormatter;
    }

    #[Route('/', methods: ['GET'])]
    public function getPosts(): JsonResponse
    {
        $posts = $this->postRepository->findAll();
        return $this->apiFormatter->success($posts, 'List of posts');
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getPost(int $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            return $this->apiFormatter->error('Post not found', 404);
        }

        return $this->apiFormatter->success($post, 'Post details');
    }
}
