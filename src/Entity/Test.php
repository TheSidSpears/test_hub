<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $failedAttempts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $successAttempts = 0;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getFailedAttempts(): int
    {
        return $this->failedAttempts;
    }

    public function incFailedAttempts()
    {
        ++$this->failedAttempts;
    }

    public function getSuccessAttempts(): int
    {
        return $this->successAttempts;
    }

    public function incSuccessAttempts()
    {
        ++$this->successAttempts;
    }

    public function getAllAttempts(): int
    {
        return $this->failedAttempts + $this->successAttempts;
    }

    /**
     * Set number of failed attempts for instantly created item
     * Used only for fixtures, tests, e.g
     *
     * Use incFailedAttempts in production
     *
     * @param $failedAttempts
     */
    public function setFailedAttempts(int $failedAttempts)
    {
        if ($this->failedAttempts == 0) {
            $this->failedAttempts = $failedAttempts;
        }
    }

    /**
     * Set number of success attempts for instantly created item
     * Used only for fixtures, tests, e.g
     *
     * Use incSuccessAttempts in production
     *
     * @param $successAttempts
     */
    public function setSuccessAttempts(int $successAttempts)
    {
        if ($this->successAttempts == 0) {
            $this->successAttempts = $successAttempts;
        }
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    public function getTimeLimit(): \DateTime
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(\DateTime $timeLimit)
    {
        $this->timeLimit = $timeLimit;

    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags(): Collection
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
        if ($tag->getTests()->contains($this)) {
            $tag->removeTest($this);
        }
    }

    /**
     * @return ArrayCollection|Question[]
     */
    public function getQuestions(): Collection
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

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }
}
