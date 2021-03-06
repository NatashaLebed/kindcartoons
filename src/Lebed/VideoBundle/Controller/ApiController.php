<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;

class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(resource=true,
     * output="Lebed\VideoBundle\Entity\Video")
     * @return array
     * @View(templateVar="videos")
     */
    public function getVideosAction()
    {
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findAll();
        return $videos;
    }

    /**
     * @ApiDoc(resource=true,
     * output="Lebed\VideoBundle\Entity\Video")
     * return mixed
     * @View(templateVar="video")
     */
    public function getVideoAction($id)
    {
        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->find($id);
        return $video;
    }
}