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
            ->addRole('ROLE_USER')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT));
        
        $manager->persist($user);

        $tags = [];
        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word);
            $manager->persist($tag);
            $manager->flush();
            $tags[] = $tag;
        }

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle($faker->sentence(6))
                ->setContent($faker->paragraph(4))
                ->addTag($tags[$i % 5])
                ->addTag($tags[($i + 2) % 5]);

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
