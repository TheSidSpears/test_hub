<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="integer")
     */
    private $failedAttempts;

    /**
     * @ORM\Column(type="integer")
     */
    private $successAttempts;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="tests")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
}
