<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowController extends Controller
{
    public function indexAction()
    {
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findAll();
        return $this->render('LebedVideoBundle:Show:index.html.twig', array('videos' => $videos));
    }

    public function showVideoPageAction($slug)
    {
        $video = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findOneBySlug($slug);

        return $this->render('LebedVideoBundle:Show:showVideoPage.html.twig', array('video' => $video));
    }



    public function videosOfCountryAction($id)
    {
        $country = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->find($id);

        if($this->getUser() and $this->get('session')->get('user_menu') == true){

            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
                           ->findByCountryUserVideo($country, $this->getUser()->getVideoIds());
        }
        else {
            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByCountry($country->getId());
        }

        return $this->render('LebedVideoBundle:Show:index.html.twig', array('videos' => $videos));
    }



    public function videosOnLanguageAction($id)
    {
        $language = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->find($id);
        if($this->getUser() and $this->get('session')->get('user_menu') == true){

            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
                            ->findByLanguageUserVideo($language, $this->getUser()->getVideoIds());
        }
        else {
            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByLanguage($language);
        }

        return $this->render('LebedVideoBundle:Show:index.html.twig', array('videos' => $videos));
    }



    public function videosOfTypeAction($id)
    {
        $type = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->find($id);

        if($this->getUser() and $this->get('session')->get('user_menu') == true){

            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
                           ->findByTypeUserVideo($type, $this->getUser()->getVideoIds());
        }
        else {
            $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')->findByType($type);
        }

        return $this->render('LebedVideoBundle:Show:index.html.twig', array('videos' => $videos));
    }



    public function videosOfCategoryAction($id)
    {
        $videos = $this->getDoctrine()->getRepository('LebedVideoBundle:Video')
            ->findByCategory($id);

        if (!$videos) {
            throw $this->createNotFoundException('No posts found');
        }

        return $this->render('LebedVideoBundle:Show:index.html.twig', array('videos'=>$videos));
    }


}