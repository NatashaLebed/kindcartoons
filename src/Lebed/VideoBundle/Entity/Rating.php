<?php

namespace Lebed\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Image
 * @package Lebed\VideoBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="rating")
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Video", inversedBy="ratings")
     */
    protected $video;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lebed\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected $weight;

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
     * Set video
     *
     * @param \Lebed\VideoBundle\Entity\Video $video
     * @return Rating
     */
    public function setVideo(\Lebed\VideoBundle\Entity\Video $video = null)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return \Lebed\VideoBundle\Entity\Video 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set user
     *
     * @param \Lebed\UserBundle\Entity\User $user
     * @return Rating
     */
    public function setUser(\Lebed\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Lebed\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Rating
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }
}