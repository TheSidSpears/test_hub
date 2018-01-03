<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="^[a-z]+[ ]*[a-z]+$",
     *     message="Tag must be consisting of alphabetic character and space"
     * )
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Test", mappedBy="tags")
     */
    private $tests;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
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
        $this->name = strtolower($name);
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTests()
    {
        return $this->tests;
    }

    public function addTest(Test $test)
    {
        if ($this->tests->contains($test)) {
            return;
        }

        $this->tests[] = $test;
        // not needed for persistence, just keeping both sides in sync
        $test->addTag($this);
    }

    public function removeTest(Test $test)
    {
        $this->tests->removeElement($test);
        // not needed for persistence, just keeping both sides in sync
        if ($test->getTags()->contains($this)) {
            $test->removeTag($this);
        }
    }
}
