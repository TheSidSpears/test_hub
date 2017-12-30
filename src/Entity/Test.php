<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"name"})
     *
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $failedAttempts;

    /**
     * @ORM\Column(type="integer")
     */
    private $successAttempts;

    /**
     * @ORM\Column(type="time")
     */
    private $timeLimit;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Question",
     *     mappedBy="test",
     *     )
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdTests")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="tests")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFailedAttempts()
    {
        return $this->failedAttempts;
    }

    public function incFailedAttempts()
    {
        ++$this->failedAttempts;
    }

    public function getSuccessAttempts()
    {
        return $this->successAttempts;
    }

    public function incSuccessAttempts()
    {
        ++$this->successAttempts;
    }

    public function getAllAttempts()
    {
        return $this->failedAttempts + $this->successAttempts;
    }

    //todo access using method only from AppFixtures
    public function setFailedAttempts($failedAttempts)
    {
        $this->failedAttempts = $failedAttempts;
    }

    //todo access using method only from AppFixtures
    public function setSuccessAttempts($successAttempts)
    {
        $this->successAttempts = $successAttempts;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getTimeLimit()
    {
        return $this->timeLimit;
    }

    public function setTimeLimit($timeLimit)
    {
        $this->timeLimit = $timeLimit;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Tag $tag)
    {
        if ($this->tags->contains($tag)) {
            return;
        }

        $this->tags[] = $tag;
        // not needed for persistence, just keeping both sides in sync
        $tag->addTest($this);
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
        // not needed for persistence, just keeping both sides in sync
        $tag->removeTest($this);
    }

    /**
     * @return ArrayCollection|Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestion(Question $question)
    {
        if ($this->questions->contains($question)) {
            return;
        }

        $this->questions[] = $question;

        $question->setTest($this);
    }

    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);

        $question->setTest(null);
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }
}
