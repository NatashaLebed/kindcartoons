<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function showUserMenuAction(Request $request)
    {
        if($this->getUser()){
            $this->get('session')->set('user_menu', 'true');
        }

        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }

    public function hideUserMenuAction(Request $request)
    {
        if($this->getUser()){
            $this->get('session')->remove('user_menu');
        }

        return $this->redirect($this->generateUrl('lebed_video_homepage'));
    }
}
