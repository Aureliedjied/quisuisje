<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Vote;
use App\Entity\Reaction;
use App\Entity\Presentation;
use App\Entity\Comment;
use App\Entity\Riddle;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        
        // Création des utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $users[] = $user;
            $manager->persist($user);
        }

        // Création des présentations associées aux utilisateurs
        foreach ($users as $user) {
            $presentation = new Presentation();
            $presentation->setTitle($faker->sentence);
            $presentation->setContent($faker->realText());
            $presentation->setUser($user); 
            $manager->persist($presentation);
        }

        // Création des sujets fictifs associés aux utilisateurs
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $topic = new Topic();
                $topic->setTitle($faker->sentence);
                $topic->setContent($faker->realText());
                $topic->setAuthor($user);
                $manager->persist($topic);
            }
        }

        // Création des commentaires fictifs associés aux devinettes
        $riddles = $manager->getRepository(Riddle::class)->findAll();
        foreach ($riddles as $riddle) {
            for ($i = 0; $i < 3; $i++) {
                $comment = new Comment();
                $comment->setContent($faker->realText());
                $comment->setAuthor($faker->userName);
                $comment->setRiddle($riddle);
                $manager->persist($comment);
            }
        }

        // Création des votes fictifs associés aux utilisateurs et aux devinettes
        foreach ($users as $user) {
            foreach ($riddles as $riddle) {
                $vote = new Vote();
                $vote->setValue(rand(1, 5)); 
                $vote->setVoter($user);
                $vote->setRiddle($riddle);
                $manager->persist($vote);
            }
        }

        // Création des réactions fictives associées aux utilisateurs et aux sujets
        $topics = $manager->getRepository(Topic::class)->findAll();
        foreach ($users as $user) {
            foreach ($topics as $topic) {
                $reaction = new Reaction();
                $reaction->setUser($user);
                $reaction->setTopic($topic);
                $reaction->setEmoji('👍'); 
                $manager->persist($reaction);
            }
        }

        $manager->flush();
    }
}
