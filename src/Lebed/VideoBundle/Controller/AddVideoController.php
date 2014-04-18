<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lebed\VideoBundle\Entity\Video;
use Lebed\VideoBundle\Entity\Image;
use Lebed\VideoBundle\Form\Type\VideoType;

class AddVideoController extends Controller
{
    public  function addVideoAction(Request $request)
    {
        $video = new Video();

        $form = $this->createForm(new VideoType(), $video);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $url = $video->getLink();
            $parsed_url = parse_url($url);
            parse_str($parsed_url['query'], $parsed_query);
            $newlink = '<iframe src="http://www.youtube.com/embed/' . $parsed_query['v'] . '" type="text/html" width="400" height="300" frameborder="0"></iframe>';
            $video->setLink($newlink);
            $json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$parsed_query['v'] ."?v=2&alt=jsonc"));

            $image = new Image();
            $image->setTitle($video->getTitle());
            $image->setThumblnail($json->data->thumbnail->sqDefault);
            $image->setSrc($json->data->thumbnail->hqDefault);
            $image->setVideo($video);

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('lebed_video_homepage'));

        }

        return $this->render('LebedVideoBundle:AddVideo:addVideo.html.twig',
            array('video' => $video,
                'form' => $form->createView(),
            ));
    }
}