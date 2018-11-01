<?php

namespace AiO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    public function localeAction(Request $request, $locale)
    {
        $this->container->get('session')->set('locale',$locale);
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
}
