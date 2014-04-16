<?php

namespace Lebed\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=64)
     */
    protected $first_name;

    /**
     * @ORM\Column(length=64)
     */
    protected $last_name;

    /**
     * @ORM\Column(length=16)
     */
    protected $gender;

    /**
     * @ORM\Column(type="date")
     */
    protected $birth_day;

    /**
     * @ORM\Column(type="time")
     */
    protected $time_limit;

    /**
     * @ORM\ManyToMany(targetEntity="Lebed\VideoBundle\Entity\Video", inversedBy="users")
     * @ORM\JoinTable(name="videos_users")
     */
    protected $videos;

    public function __construct()
    {
        parent::__construct();
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
     * Add videos
     *
     * @param \Lebed\VideoBundle\Entity\Video $videos
     * @return User
     */
    public function addVideo(\Lebed\VideoBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;
    
        return $this;
    }

    /**
     * Remove videos
     *
     * @param \Lebed\VideoBundle\Entity\Video $videos
     */
    public function removeVideo(\Lebed\VideoBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param $video_id
     * @return bool
     */
    public function videoIsAdded($video_id)
    {
        foreach($this->getVideos() as $video){
            if($video->getId() == $video_id){

                return true;
            }
        }

        return false;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set time_limit
     *
     * @param \DateTime $timeLimit
     * @return User
     */
    public function setTimeLimit($timeLimit)
    {
        $this->time_limit = $timeLimit;
    
        return $this;
    }

    /**
     * Get time_limit
     *
     * @return \DateTime 
     */
    public function getTimeLimit()
    {
        return $this->time_limit;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birth_day
     *
     * @param \date $birthDay
     * @return User
     */
    public function setBirthDay(\date $birthDay)
    {
        $this->birth_day = $birthDay;
    
        return $this;
    }

    /**
     * Get birth_day
     *
     * @return \date
     */
    public function getBirthDay()
    {
        return $this->birth_day;
    }
}