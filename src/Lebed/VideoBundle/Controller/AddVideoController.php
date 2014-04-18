<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lebed\VideoBundle\Entity\Video;
use Lebed\VideoBundle\Form\Type\VideoType;

class AddVideoController extends Controller
{
    public  function addVideoAction(Request $request)
    {
        $video = new Video();

        $form = $this->createForm(new VideoType(), $video);
        $form->handleRequest($request);

        if ($form->isValid()) {
           $this->get('add_video.service')->addVideo($video);

            return $this->redirect($this->generateUrl('lebed_video_homepage'));
        }

        return $this->render('LebedVideoBundle:AddVideo:addVideo.html.twig',
            array('video' => $video,
                'form' => $form->createView(),
            ));
    }
}