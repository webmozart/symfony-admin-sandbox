<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\SandboxBundle\Entity;

/**
 * @orm:Entity
 * @orm:HasLifecycleCallbacks
 */
class Comment
{
    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;
    const STATUS_MODERATE = 2;

    protected static $statusCodes = array(
        self::STATUS_MODERATE => 'moderate',
        self::STATUS_INVALID => 'invalid',
        self::STATUS_VALID   => 'valid',
    );

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

    /**
     * @orm:Column(type="string", length="255")
     * @validation:Url
     * @validation:MaxLength(255)
     * @validation:NotNull
     */
    protected $url;

    /**
     * @orm:Column(type="text")
     * @validation:AssertType("string")
     * @validation:NotNull
     */
    protected $message;

    /**
     * @orm:Column(type="datetime")
     * @validation:AssertType("\DateTime")
     * @validation:NotNull(groups="PrePersist")
     */
    protected $createdAt;

    /**
     * @orm:Column(type="datetime")
     * @validation:AssertType("\DateTime")
     * @validation:NotNull(groups="PrePersist")
     */
    protected $updatedAt;

    /**
     * @orm:Column(type="integer")
     * @validation:AssertType("numeric")
     * @validation:Choice(callback="getStatuses")
     * @validation:NotNull
     */
    protected $status = self::STATUS_VALID;

    /**
     * @orm:ManyToOne(targetEntity="Post", inversedBy="comments")
     * @validation:AssertType("Application\SandboxBundle\Entity\Post")
     * @validation:NotNull
     */
    protected $post;

    /**
     * @orm:PrePersist
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setUpdatedAt(new \DateTime);
    }

    /**
     * @orm:PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param text $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return text $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return text $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public static function getStatusCodes()
    {
        return self::$statusCodes;
    }

    public function getStatusCode()
    {
        return isset(self::$statusCodes[$this->getStatus()])
                ? self::$statusCodes[$this->getStatus()]
                : null;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = (integer)$status;
    }

    /**
     * Get status
     *
     * @return integer $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    public static function getStatuses()
    {
        return array_keys(self::$statusCodes);
    }

    /**
     * Set post
     *
     * @param Application\SandboxBundle\Entity\Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return Application\SandboxBundle\Entity\Post $post
     */
    public function getPost()
    {
        return $this->post;
    }
}