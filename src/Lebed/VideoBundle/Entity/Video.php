<?php

namespace Lebed\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Lebed\UserBundle\Entity\User as User;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Class Video
 * @package Lebed\VideoBundle\Entity
 * @ORM\Entity(repositoryClass="Lebed\VideoBundle\Entity\VideoRepository")
 * @ORM\Table(name="video")
 * @ExclusionPolicy("all")
 *
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(length=64)
     * @Expose
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="videos")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\Column(length=64)
     * @Expose
     */
    protected $author;

    /**
     * @ORM\Column(type="integer")
     */
    protected $year;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="videos")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="videos")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     */
    protected $language = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="videos")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type = NULL;

    /**
     * @Gedmo\Slug(fields={"title"}, style="camel")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text")
     * @Expose
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $link;

    /**
     * @Doctrine\ORM\Mapping\Column(type="datetime", name="created_at")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @Doctrine\ORM\Mapping\Column(type="datetime", name="updated_at")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var integer
     * @ORM\Column(type = "integer")
     */
    protected $viewsNumber = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Lebed\UserBundle\Entity\User", mappedBy="videos")
     */
    protected $users;

    /** @ORM\OneToOne(targetEntity="Image", mappedBy="video") */
    protected $image;

    /** @ORM\OneToMany(targetEntity="Rating", mappedBy="video") */
    protected $ratings;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Video
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Video
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Video
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Video
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Video
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Video
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set viewsNumber
     *
     * @param integer $viewsNumber
     * @return Video
     */
    public function setViewsNumber($viewsNumber)
    {
        $this->viewsNumber = $viewsNumber;
    
        return $this;
    }

    /**
     * Get viewsNumber
     *
     * @return integer 
     */
    public function getViewsNumber()
    {
        return $this->viewsNumber;
    }

    /**
     * Set category
     *
     * @param \Lebed\VideoBundle\Entity\Category $category
     * @return Video
     */
    public function setCategory(\Lebed\VideoBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Lebed\VideoBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set country
     *
     * @param \Lebed\VideoBundle\Entity\Country $country
     * @return Video
     */
    public function setCountry(\Lebed\VideoBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Lebed\VideoBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set language
     *
     * @param \Lebed\VideoBundle\Entity\Language $language
     * @return Video
     */
    public function setLanguage(\Lebed\VideoBundle\Entity\Language $language = null)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return \Lebed\VideoBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set type
     *
     * @param \Lebed\VideoBundle\Entity\Type $type
     * @return Video
     */
    public function setType(\Lebed\VideoBundle\Entity\Type $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Lebed\VideoBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add users
     *
     * @param \Lebed\UserBundle\Entity\User $users
     * @return Video
     */
    public function addUser(\Lebed\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Lebed\UserBundle\Entity\User $users
     */
    public function removeUser(\Lebed\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set image
     *
     * @param \Lebed\VideoBundle\Entity\Image $image
     * @return Video
     */
    public function setImage(\Lebed\VideoBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \Lebed\VideoBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add ratings
     *
     * @param \Lebed\VideoBundle\Entity\Rating $ratings
     * @return Video
     */
    public function addRating(\Lebed\VideoBundle\Entity\Rating $ratings)
    {
        $this->ratings[] = $ratings;
    
        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \Lebed\VideoBundle\Entity\Rating $ratings
     */
    public function removeRating(\Lebed\VideoBundle\Entity\Rating $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @return float
     */
    public function getVideoRating()
    {
        $k = 0;
        $sum = 0;
        foreach($this->getRatings() as $rating)
        {
            $k++;
            $sum += $rating->getWeight();

        }

        if($k>0){
            return $sum/$k;
        }
        else{
            return null;
        }

    }

    /**
     * @param $user
     * @return bool
     */
    public function isVoting($user)
    {
        foreach($this->getRatings() as $rating){
            if($rating->getUser()->getId() == $user->getId())
            {
                return true;
            }
        }
        return false;
    }
}