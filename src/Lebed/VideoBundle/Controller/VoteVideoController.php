<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Lebed\VideoBundle\Entity\Rating;

class VoteVideoController extends Controller
{
    public function voteVideoAction(Request $request)
    {
        $user = $this->getUser();

        if ($this->getRequest()->isXmlHttpRequest())
        {
            $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
                ->find($this->getRequest()->get('video_id'));
            if($video)
            {
                $vote = new Rating();
                $vote->setUser($user);
                $vote->setVideo($video);
                $vote->setWeight($this->getRequest()->get('weight'));

                $this->getDoctrine()->getManager()->persist($vote);
                $this->getDoctrine()->getManager()->flush();

                $res = array(
                    'status' => 'Success',
                    'content' => $video->getVideoRating()
                );
            }
            else
            {
                $res = array(
                    'status' => 'Error',
                    'content' => "Video not found"
                );
            }

        }
        else
        {
            $res = array(
                'status' => 'Error',
                'content' => "Not AJAX request"
            );
        }
        return new Response(json_encode($res));
    }
}