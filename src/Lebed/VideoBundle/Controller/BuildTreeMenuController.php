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
        $countries = $this->getDoctrine()->getRepository('LebedVideoBundle:Country')->findAll();
        $languages = $this->getDoctrine()->getRepository('LebedVideoBundle:Language')->findAll();
        $types = $this->getDoctrine()->getRepository('LebedVideoBundle:Type')->findAll();

        return $this->render('LebedVideoBundle:BuildTreeMenu:rightMenu.html.twig',
            array('countries' => $countries,
                'languages' => $languages,
                'types' => $types,
            ));
    }
}