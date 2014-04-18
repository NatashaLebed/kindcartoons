<?php

namespace Lebed\VideoBundle\Service;

use Lebed\VideoBundle\Entity\Video;
use Lebed\VideoBundle\Entity\Image;
use Doctrine\ORM\EntityManager;

class AddVideoService {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addVideo(Video $video)
    {
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

        $this->em->persist($video);
        $this->em->persist($image);
        $this->em->flush();

//        $em = $this->getDoctrine()->getManager();
//        $em->persist($video);
//        $em->persist($image);
//        $em->flush();

    }
}