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
    public function testZeroQuestionsForNewTest()
    {
        $test = new Test();
        $this->assertCount(0, $test->getQuestions());
    }

    public function testZeroTagsForNewTest()
    {
        $test = new Test();
        $this->assertCount(0, $test->getTags());
    }


    public function testCanAddQuestionForTest()
    {
        $test = new Test();
        $question1 = new Question();

        $test->addQuestion($question1);
        $questions = $test->getQuestions();

        $this->assertTrue($questions->contains($question1));
    }

    public function testCanAddTagForTest()
    {
        $test = new Test();
        $tag1 = new Tag();

        $test->addTag($tag1);
        $tags = $test->getTags();

        $this->assertTrue($tags->contains($tag1));
    }

    public function testCanRemoveQuestionForTest()
    {
        //todo
    }

    public function testCanRemoveTagForTest()
    {
        //todo
    }


    // Attempts

    public function testSuccessAttemptsIsZeroForNewTest()
    {
        $test = new Test();
        $this->assertSame(0, $test->getSuccessAttempts());
    }

    public function testFailedAttemptsIsZeroForNewTest()
    {
        $test = new Test();
        $this->assertSame(0, $test->getFailedAttempts());
    }

    public function testCanSetSuccessAttemptsForNewTest()
    {
        $test = new Test();
        $test->setSuccessAttempts(66);
        $this->assertSame(66, $test->getSuccessAttempts());
    }

    public function testCanNotSetSuccessAttemptsTwice()
    {
        $test = new Test();
        $test->setSuccessAttempts(66);
        $test->setSuccessAttempts(100);
        $this->assertSame(66, $test->getSuccessAttempts());
    }

    public function testCanSetFailedAttemptsForNewTest()
    {
        $test = new Test();
        $test->setFailedAttempts(66);
        $this->assertSame(66, $test->getFailedAttempts());
    }

    public function testCanNotSetFailedAttemptsTwice()
    {
        $test = new Test();
        $test->setFailedAttempts(66);
        $test->setFailedAttempts(100);
        $this->assertSame(66, $test->getFailedAttempts());
    }

    public function testAllAttemptsIncreasedWithSuccessAndFailed()
    {
        $test = new Test();
        $num1 = 55;
        $num2 = 45;

        $test->setSuccessAttempts($num1);
        $test->setFailedAttempts($num2);
        $this->assertSame($num1 + $num2, $test->getAllAttempts());

        $test->incSuccessAttempts();
        $test->incFailedAttempts();

        $this->assertSame($num1 + 1, $test->getSuccessAttempts());
        $this->assertSame($num2 + 1, $test->getFailedAttempts());
        $this->assertSame(($num1 + 1) + ($num2 + 1), $test->getAllAttempts());

    }
}