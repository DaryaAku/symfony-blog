<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    private PostRepository $postRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PostRepository $postRepository, EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function getAllPosts(): array
    {
        $posts = $this->postRepository->findAll();

        return $posts;
    }

    public function createPost(string $title, string $content): Post
    {
        $post = new Post();
        $post->setTitle($title)
            ->setContent($content);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    public function deletePost(int $id): void
{
    $post = $this->postRepository->find($id);

    if (!$post) {
        throw new \Exception("Post not found");
    }

    $comments = $post->getComments();
    foreach ($comments as $comment) {
        $this->entityManager->remove($comment);
    }

    $this->entityManager->remove($post);
    $this->entityManager->flush();
}
}
