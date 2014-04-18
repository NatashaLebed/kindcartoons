<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CopyVideoToUserController extends Controller
{
    public  function copyAction($video_id)
    {
        $user = $this->getUser();

        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
            ->find($video_id);

        $user->addVideo($video);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }
}