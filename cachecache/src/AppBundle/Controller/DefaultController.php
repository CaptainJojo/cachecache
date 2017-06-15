<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    /**
     * @Route("/article", name="article")
     */
    public function articleAction()
    {
      $client = $this->get('csa_guzzle.client.cachecache_api');
      $apiResponse = $client->request('GET', 'article');
      $article = json_decode($apiResponse->getBody()->getContents());

      $response = $this->render('default/article.html.twig', ['article' => $article]);
      $response->setMaxAge(0);
      $response->setPublic();

      return $response;
    }

    /**
     * @Route("/comment", name="comment")
     */
    public function commentAction()
    {
      $client = $this->get('csa_guzzle.client.cachecache_api');
      $apiResponse = $client->request('GET', 'comment/3');
      $comments = json_decode($apiResponse->getBody()->getContents());

      return new JsonResponse($comments);
    }
}
