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

        // Création de topics
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $topic = new Topic();
                $topic->setTitle($faker->sentence);
                $topic->setContent($faker->realText());
                $topic->setAuthor($user);
                $manager->persist($topic);
            }
        }

        // Creations de devinettes
        $riddles = [];
            for ($i = 0; $i < 5; $i++) {
                $riddle = new Riddle();
                $riddle->setQuestion($faker->sentence);
                $riddle->setAnswer($faker->word);
                $riddle->setHint1($faker->word);
                $riddle->setHint2($faker->word);
                $riddle->setAuthor($user);
                $riddles[] = $riddle;
                $manager->persist($riddle);
            }

        $manager->flush();
    }
}
