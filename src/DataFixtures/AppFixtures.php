<?php


namespace App\DataFixtures;


use App\Entity\Tag;
use App\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    //todo Learn how to use nelmio/alice 3 in Symfony 4 and use it
    public function load(ObjectManager $manager)
    {
        $tags = [];
        foreach ($this->tagNames() as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);

            $tags[] = $tag;
        }

        foreach ($this->testNames() as $testName) {
            $test = new Test();
            $test->setName($testName);

            //todo it's creepy
            for ($i =1; $i<=rand(1,20);$i++){
                $test->incFailedAttempts();
            }
            for ($i =1; $i<=rand(1,20);$i++){
                $test->incSuccessAttempts();
            }

            $test->addTag($tags[array_rand($tags)]);
            $test->addTag($tags[array_rand($tags)]);
            $test->addTag($tags[array_rand($tags)]);

            $manager->persist($test);
        }

        $manager->flush();
    }

    public function testNames()
    {
        return [
            'Electrodynamics',
            'Astronomy',
            'Geometry',
            'Psychology',
            'Physics',
            'Algorithms',
            'History',
            'Art history',
            'Music theory',
            'PHP & MySQL',
            'GIT basics',
            '101 programming'
        ];
    }

    public function tagNames()
    {
        return [
            'easy',
            'hard',
            'excellent',
            'long',
            'fast',
            'boring',
            'tedious',
        ];
    }
}