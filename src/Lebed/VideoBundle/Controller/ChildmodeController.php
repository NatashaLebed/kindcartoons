<?php

namespace Lebed\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ChildmodeController extends Controller
{
    public function childAction(Request $request)
    {
        if ($this->getRequest()->isXmlHttpRequest())
        {
            $this->get('session')->set('child', true);

            $time = date_timestamp_get($this->getUser()->getTimeLimit());

            if ($time == 1397854800){
                $time = strtotime('30 minutes', date_timestamp_get($this->getUser()->getTimeLimit()));
            }

            $this->get('session')->set('time', $time);
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