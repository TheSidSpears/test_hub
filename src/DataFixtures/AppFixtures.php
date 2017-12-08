<?php


namespace App\DataFixtures;


use App\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    //todo Learn how to use nelmio/alice 3 in Symfony 4 and use it
    public function load(ObjectManager $manager)
    {
        foreach ($this->testNames() as $testName){
            $test = new Test();
            $test->setName($testName);
            $manager->persist($test);
        }
        $manager->flush();
    }

    public function testNames(){
        $tests = [
            'Арифметика',
            'Электродинамика',
            'Основы космических полётов',
            'Геометрия',
            'Психология',
            'Физика',
            'Астрономия',
            'История',
            'История искусств',
            'Музыкальная теория',
            'PHP и MySQL',
            'Основы GIT'
        ];
        return $tests;
    }
}