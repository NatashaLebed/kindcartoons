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

    public function childAction(Request $request)
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
            $this->get('session')->set('child', true);

            $this->get('session')->set('time',date_timestamp_get($this->getUser()->getTimeLimit()));
            $this->get('session')->set('time_setup', $this->getRequest()->get('time_setup'));
            $res = array(
                'status' => 'Success',
                'content' => 'Детский режим включен'
            );
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

    public function offChildAction(Request $request)
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
            $this->get('session')->remove('child');
            $this->get('session')->remove('time');
            $this->get('session')->remove('time_setup');
            $res = array(
                'status' => 'Success',
                'content' => 'Детский режим выключен'
            );
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

    public function checkPassAction(Request $request)
    {

        /** @var User $user */
        $user = $this->getUser();

        if ($user and $this->getRequest()->isMethod('post'))
        {
            $password = $this->getRequest()->get('user_password');

            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $encoded_pass = $encoder->encodePassword($password, $user->getSalt());

            if ($user->getPassword() == $encoded_pass) {

                $this->get('session')->remove('child');
                $this->get('session')->remove('time');
                $this->get('session')->remove('time_setup');

            }
        }
        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }
}
