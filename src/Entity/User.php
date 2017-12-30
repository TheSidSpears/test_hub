<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="author")
     */
    private $createdTests;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedTests()
    {
        return $this->createdTests;
    }

    public function setCreatedTests($createdTests)
    {
        $this->createdTests = $createdTests;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getFullName()
    {
        return trim($this->getFirstName() . ' ' . $this->getLastName());
    }

    public function setFullName($fullName)
    {
        $names = explode(' ', $fullName);
        $firstName = array_shift($names);
        $lastName = implode(' ', $names);

        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }
}
