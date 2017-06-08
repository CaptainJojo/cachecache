<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cachedTest = $this->get('cache.app')->getItem('test');

        if (!$cachedTest->isHit()) {
            $time = time();
            $cachedTest->set($time);
            $cachedTest->expiresAfter(30);
            $this->get('cache.app')->save($cachedTest);
        } else {
            $time = $cachedTest->get();
        }

        // replace this example code with whatever you need
        $response = $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'time' => $time
        ]);

        $response->setMaxAge(0);
        $response->setPublic();

        return $response;
    }

    /**
     * @Route("/esi/{cache}", name="esi")
     */
    public function esiAction($cache)
    {
      $response = $this->render('default/esi.html.twig');
      $response->setSharedMaxAge($cache);
      $response->setPublic();

      return $response;
    }
}
