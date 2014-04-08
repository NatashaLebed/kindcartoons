<?php

namespace Lebed\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Anotation as Gedmo;

/**
 * Class Image
 * @package Lebed\VideoBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(length=64) **/
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $src;

    /**
     * @ORM\Column(type="string")
     */
    protected $thumblnail;

    /**
     * @ORM\ManyToOne(targetEntity="Video", inversedBy="images")
     */
    protected $video;


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
     * @return Image
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
     * Set src
     *
     * @param string $src
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;
    
        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set thumblnail
     *
     * @param string $thumblnail
     * @return Image
     */
    public function setThumblnail($thumblnail)
    {
        $this->thumblnail = $thumblnail;
    
        return $this;
    }

    /**
     * Get thumblnail
     *
     * @return string 
     */
    public function getThumblnail()
    {
        return $this->thumblnail;
    }

    /**
     * Set video
     *
     * @param \Lebed\VideoBundle\Entity\Video $video
     * @return Image
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
}