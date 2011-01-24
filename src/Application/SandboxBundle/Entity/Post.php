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
 * @orm:Entity(repositoryClass="PostRepository")
 */
class Post
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
    protected $title;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:AssertType("string")
     * @validation:MaxLength(255)
     * @validation:NotNull
     */
    protected $slug;

    /**
     * @orm:Column(type="text")
     * @validation:AssertType("string")
     * @validation:NotNull
     */
    protected $abstract;

    /**
     * @orm:Column(type="text")
     * @validation:AssertType("string")
     * @validation:NotNull
     */
    protected $content;

    /**
     * @orm:ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @validation:AssertType("Application\SandboxBundle\Entity\Tag")
     * @validation:NotNull
     */
    protected $tags;

    /**
     * @orm:OneToMany(targetEntity="Comment", mappedBy="post")
     * @validation:AssertType("Application\SandboxBundle\Entity\Comment")
     * @validation:NotNull
     */
    protected $comments;

    /**
     * @orm:Column(type="boolean")
     * @validation:AssertType("boolean")
     * @validation:NotNull
     */
    protected $enabled;

    /**
     * @orm:Column(type="datetime", nullable="true")
     * @validation:AssertType("\DateTime")
     */
    protected $publicationDateStart;

    /**
     * @orm:Column(type="datetime")
     * @validation:AssertType("\DateTime")
     * @validation:NotNull
     */
    protected $createdAt;

    /**
     * @orm:Column(type="datetime")
     * @validation:AssertType("\DateTime")
     * @validation:NotNull
     */
    protected $updatedAt;

    /**
     * @orm:Column(type="boolean")
     * @validation:AssertType("boolean")
     * @validation:NotNull
     */
    protected $commentsEnabled = true;

    /**
     * @orm:Column(type="datetime", nullable="true")
     * @validation:AssertType("\DateTime")
     */
    protected $commentsCloseAt;

    /**
     * @orm:Column(type="integer")
     * @validation:AssertType("integer")
     * @validation:NotNull
     */
    protected $commentsDefaultStatus;

    /**
     * @orm:ManyToOne(targetEntity="Author")
     * @validation:AssertType("Application\SandboxBundle\Entity\Author")
     * @validation:NotNull
     */
    protected $author;

    public function __construct()
    {
        $this->tags     = new \Doctrine\Common\Collections\ArrayCollection;
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection;
    }

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        $this->setSlug(Tag::slugify($title));
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set abstract
     *
     * @param text $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Get abstract
     *
     * @return text $abstract
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set slug
     *
     * @param integer $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return integer $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set publication_date_start
     *
     * @param datetime $publicationDateStart
     */
    public function setPublicationDateStart($publicationDateStart)
    {
        $this->publicationDateStart = $publicationDateStart;
    }

    /**
     * Get publication_date_start
     *
     * @return datetime $publicationDateStart
     */
    public function getPublicationDateStart()
    {
        return $this->publicationDateStart;
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

    /**
     * Add comments
     *
     * @param Application\SandboxBundle\Entity\Comment $comments
     */
    public function addComments(\Application\SandboxBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        foreach($this->comments as $comment) {
            $comment->setPost($this);
        }
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tags
     *
     * @param Application\SandboxBundle\Entity\Tag $tags
     */
    public function addTags(\Application\SandboxBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getYear()
    {
        return $this->getCreatedAt()->format('Y');
    }

    public function getMonth()
    {
        return $this->getCreatedAt()->format('m');
    }

    public function getDay()
    {
        return $this->getCreatedAt()->format('d');
    }
    /**
     * Set comments_enabled
     *
     * @param boolean $commentsEnabled
     */
    public function setCommentsEnabled($commentsEnabled)
    {
        $this->commentsEnabled = $commentsEnabled;
    }

    /**
     * Get comments_enabled
     *
     * @return boolean $commentsEnabled
     */
    public function getCommentsEnabled()
    {
        return $this->commentsEnabled;
    }

    /**
     * Set comments_close_at
     *
     * @param datetime $commentsCloseAt
     */
    public function setCommentsCloseAt($commentsCloseAt)
    {
        $this->commentsCloseAt = $commentsCloseAt;
    }

    /**
     * Get comments_close_at
     *
     * @return datetime $commentsCloseAt
     */
    public function getCommentsCloseAt()
    {
        return $this->commentsCloseAt;
    }

    /**
     * Set comments_default_status
     *
     * @param integer $commentsDefaultStatus
     */
    public function setCommentsDefaultStatus($commentsDefaultStatus)
    {
        $this->commentsDefaultStatus = $commentsDefaultStatus;
    }

    /**
     * Get comments_default_status
     *
     * @return integer $commentsDefaultStatus
     */
    public function getCommentsDefaultStatus()
    {
        return $this->commentsDefaultStatus;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function isCommentable()
    {

        if(!$this->getCommentsEnabled())
        {
            return false;
        }

        if($this->getCommentsCloseAt() instanceof \DateTime)
        {
            return $this->getCommentsCloseAt()->diff(new \DateTime)->invert == 0 ? true : false;
        }

        return $this->getEnabled();
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

}