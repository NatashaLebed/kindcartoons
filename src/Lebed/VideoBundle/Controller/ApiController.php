<?php

namespace Lebed\GuestbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;

class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(resource=true)
     * @return array
     * @View(templateVar="posts")
     */
    public function getPostsAction()
    {
        $posts = $this->getDoctrine()->getRepository('LebedGuestbookBundle:Post')->findAll();
        return $posts;
    }

    /**
     * @ApiDoc(
     * resource=true,
     * output="Lebed\GuestbookBundle\Entity\Post")
     * return mixed
     * @View(templateVar="post")
     */
    public function getPostAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('LebedGuestbookBundle:Post')->findOneBySlug($slug);
        return $post;
    }
}