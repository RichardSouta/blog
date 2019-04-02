<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_posts",indexes={
 *     @ORM\Index(name="date_index", columns={"date"}),
 *     @ORM\Index(name="hidden_index", columns={"hidden"})
 * })
 */
class BlogPost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string",length=150,nullable=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text",nullable=false)
     */
    private $text;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $date;


    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="blogPosts")
     * @ORM\JoinTable(name="blog_post_tags")
     * @var Tag[]|ArrayCollection
     */
    private $tags;

    /**
     * @var bool
     * @ORM\Column(type="boolean",options={"default" : false})
     */
    private $hidden = false;

    /**
     * @var int
     * @ORM\Column(type="integer",options={"default" : 0})
     */
    private $viewsCount = 0;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BlogPost
     */
    public function setId(int $id): BlogPost
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BlogPost
     */
    public function setTitle(string $title): BlogPost
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return BlogPost
     */
    public function setText(string $text): BlogPost
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return BlogPost
     */
    public function setDate(\DateTime $date): BlogPost
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[]|ArrayCollection $tags
     * @return BlogPost
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     * @return BlogPost
     */
    public function setHidden(bool $hidden): BlogPost
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewsCount(): ?int
    {
        return $this->viewsCount;
    }

    /**
     * @param int $viewsCount
     * @return BlogPost
     */
    public function setViewsCount(int $viewsCount): BlogPost
    {
        $this->viewsCount = $viewsCount;
        return $this;
    }

    /**
     * @param int $number
     * @return BlogPost
     */
    public function increaseViewsCount(int $number = 1): BlogPost
    {
        $this->viewsCount += $number;
        return $this;
    }
}
