<?php

namespace Tests\App\Entity;


use App\Entity\Question;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use App\Entity\Test;

class TestEntityTest extends TestCase
{
    /** @test */
    public function testObjectCreation()
    {
        $test = new Test();

        $this->assertNull($test->getId());

        $this->assertNull($test->getName());
        $this->assertNull($test->getAuthor());
        $this->assertNull($test->getDescription());

        $this->assertNull($test->getSlug());
        $this->assertNull($test->getTimeLimit());

        $this->assertSame(0, $test->getAllAttempts());
        $this->assertNull($test->getFailedAttempts());
        $this->assertNull($test->getSuccessAttempts());

        $this->assertInstanceOf(ArrayCollection::class, $test->getQuestions());
        $this->assertCount(0, $test->getQuestions());

        $this->assertInstanceOf(ArrayCollection::class, $test->getTags());
        $this->assertCount(0, $test->getTags());
    }

    /** @test */
    public function testObjectEdit()
    {
        $test = new Test();

        $string = 'String';

        $test->setName($string);
        $this->assertSame($string, $test->getName());

        $test->setDescription($string);
        $this->assertSame($string, $test->getDescription());

        $test->setSlug($string);
        $this->assertSame($string, $test->getSlug());

        $num1 = 4;
        $num2 = 6;
        $test->setFailedAttempts($num1);
        $this->assertSame($num1, $test->getFailedAttempts());
        $test->setSuccessAttempts($num2);
        $this->assertSame($num2, $test->getSuccessAttempts());

        $test->incSuccessAttempts();
        $this->assertSame($num1++, $test->getFailedAttempts());
        $test->incFailedAttempts();
        $this->assertSame($num1++, $test->getFailedAttempts());

        $this->assertSame($num1 + $num2, $test->getAllAttempts());

        $test->setTimeLimit(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $test->getTimeLimit());


        $question = new Question();
        $test->addQuestion($question);

        $this->assertInstanceOf(ArrayCollection::class, $test->getQuestions());
        $this->assertContainsOnlyInstancesOf(Question::class, $test->getQuestions());
        $this->assertCount(1, $test->getQuestions());
        $this->assertArraySubset([$question], $test->getQuestions());

        $test->removeQuestion($question);
        $this->assertCount(0, $test->getQuestions());


        $tag = new Tag();
        $test->addTag($tag);

        $this->assertInstanceOf(ArrayCollection::class, $test->getTags());
        $this->assertContainsOnlyInstancesOf(Tag::class, $test->getTags());
        $this->assertContainsOnlyInstancesOf(Test::class, $tag->getTests());
        $this->assertCount(1, $test->getTags());
        $this->assertCount(1, $tag->getTests());
        $this->assertArraySubset([$tag], $test->getTags());

        $test->removeTag($tag);
        $this->assertCount(0, $test->getTags());
        $this->assertCount(0, $tag->getTests());


        $author = new User();
        $test->setAuthor($author);
        $this->assertInstanceOf(User::class, $test->getAuthor());
    }
}