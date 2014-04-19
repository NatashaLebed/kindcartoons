<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BuildTreeMenuController extends Controller
{
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
        if ($this->getUser() && $this->get('session')->get('user_menu') == true){

            $country = array();
            $language = array();
            $type = array();

            foreach($this->getUser()->getVideos() as $value){
                $country[] = $value->getCountry()->getId();
                $language[] = $value->getLanguage()->getId();
                $type[] = $value->getType()->getId();
            }

            $country = array_unique($country);
            $language = array_unique($language);
            $type = array_unique($type);

            $countries = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->findBy(array('id' => $country));
            $languages = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->findBy(array('id' => $language));
            $types = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->findBy(array('id' => $type));
        }

        else {
            $countries = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->findAll();
            $languages = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->findAll();
            $types = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->findAll();
        }

        return $this->render('LebedVideoBundle:BuildTreeMenu:rightMenu.html.twig',
            array('countries' => $countries,
                'languages' => $languages,
                'types' => $types,
            ));

    }
}