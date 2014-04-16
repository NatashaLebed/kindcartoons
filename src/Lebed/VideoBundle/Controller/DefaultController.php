<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Lebed\VideoBundle\Entity\Language;
use Lebed\VideoBundle\Entity\Video;
use Lebed\VideoBundle\Entity\Image;
use Lebed\VideoBundle\Entity\Rating;
use Lebed\VideoBundle\Entity\Country;
use Lebed\VideoBundle\Entity\Type;
use Lebed\VideoBundle\Form\Type\VideoType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findAll();
        return $this->render('LebedVideoBundle:Default:index.html.twig', array('videos' => $videos));
    }

    public function categoryTreeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('LebedVideoBundle:Category');
        $options = array(
            'decorate' => true,
            'nodeDecorator' => function($node) {
                    return '<a href="/category/'.$node['id'].'">'.$node['title'].'</a>';
                }
        );
        $htmlTree = $repo->childrenHierarchy(null, false,  $options);

        return new Response($htmlTree);
    }

    public function rightMenuAction()
    {
        $countries = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->findAll();
        $languages = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->findAll();
        $types = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->findAll();
        return $this->render('LebedVideoBundle:Default:rightMenu.html.twig',
            array('countries' => $countries,
                  'languages' => $languages,
                  'types' => $types,
            ));

    }

    public function videosOfCountryAction($id)
    {
        $country = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->find($id);
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByCountry($country);

        return $this->render('LebedVideoBundle:Default:index.html.twig', array('videos' => $videos));
    }

    public function videosOnLanguageAction($id)
    {
        $language = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->find($id);
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByLanguage($language);

        return $this->render('LebedVideoBundle:Default:index.html.twig', array('videos' => $videos));
    }

    public function videosOfTypeAction($id)
    {
        $type = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->find($id);
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByType($type);

        return $this->render('LebedVideoBundle:Default:index.html.twig', array('videos' => $videos));
    }

    public function videosOfCategoryAction($id)
    {
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
            ->findByCategory($id);

        if (!$videos) {
            throw $this->createNotFoundException('No posts found');
        }

        return $this->render('LebedVideoBundle:Default:index.html.twig', array('videos'=>$videos));
    }

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
           // echo '<img src="' . $json->data->thumbnail->sqDefault . '">';
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('lebed_video_homepage'));

        }

        return $this->render('LebedVideoBundle:Default:addVideo.html.twig',
            array('video' => $video,
                  'form' => $form->createView(),
            ));
    }

    public  function copyVideoToUserAction($video_id)
    {
        $user = $this->getUser();

        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
            ->find($video_id);

        $user->addVideo($video);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }

    public  function removeVideoFromUserAction($video_id)
    {
        $user = $this->getUser();

        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
            ->find($video_id);

        $user->removeVideo($video);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }

    public function showVideoPageAction($slug)
    {
        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findOneBySlug($slug);

        return $this->render('LebedVideoBundle:Default:showVideoPage.html.twig', array('video' => $video));
    }

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
