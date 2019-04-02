<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
final class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $id;

    /**
     * @var BlogPost[]
     * @ORM\ManyToMany(targetEntity="BlogPost", mappedBy="tags")
     */
    private $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Tag
     */
    public function setId(string $id): Tag
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return BlogPost[]
     */
    public function getBlogPosts(): ArrayCollection
    {
        return $this->blogPosts;
    }

    /**
     * @param BlogPost[] $blogPosts
     * @return Tag
     */
    public function setBlogPosts(array $blogPosts): Tag
    {
        $this->blogPosts = $blogPosts;
        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
