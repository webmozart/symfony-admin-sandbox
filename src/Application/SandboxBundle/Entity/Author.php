<?php

namespace Application\SandboxBundle\Entity;

/**
 * @orm:Entity
 */
class Author
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     * @validation:AssertType("integer")
     */
    protected $id;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:AssertType("string")
     * @validation:MaxLength(255)
     * @validation:NotNull
     */
    protected $name;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:Email
     * @validation:MaxLength(255)
     * @validation:NotNull
     */
    protected $email;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function __toString()
    {
        return $this->getName();
    }
}