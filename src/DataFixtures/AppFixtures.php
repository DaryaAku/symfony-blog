<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) : void    
    {
        $faker = Factory::create();

        $user = new Users();
        $user->setUsername($faker->userName)
            ->setEmail($faker->email)
            ->setPassword(password_hash('password', PASSWORD_BCRYPT));
        
        $manager->persist($user);

        $tags = [];
        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word);
            $tags[] = $tag;
            $manager->persist($tag);
        }

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle($faker->sentence(6))
                ->setContent($faker->paragraph(4))
                ->setCreatedAt($faker->dateTimeThisYear)
                ->setAuthor($user)
                ->setTags($faker->randomElements($tags, 3));

            $manager->persist($post);

            for ($j = 0; $j < 3; $j++) {
                $comment = new Comment();
                $comment->setContent($faker->sentence)
                    ->setCreatedAt($faker->dateTimeThisMonth)
                    ->setPost($post)
                    ->setAuthor($user);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
