<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;


class AppFixtures extends Fixture
{
    //todo Learn how to use nelmio/alice 3 in Symfony 4 and use it
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(
            __DIR__.'/fixtures.yml',
            [
                'testName' => $this->testName(),
                'testTag' => $this->testTag()
            ]
        );

        foreach ($objectSet->getObjects() as $entity){
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function testName()
    {
        $list = [
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
        return $list[array_rand($list)];
    }

    public function testTag()
    {
        $list = [
            'easy',
            'hard',
            'excellent',
            'long',
            'fast',
            'boring',
            'tedious',
        ];
        return $list[array_rand($list)];
    }
}