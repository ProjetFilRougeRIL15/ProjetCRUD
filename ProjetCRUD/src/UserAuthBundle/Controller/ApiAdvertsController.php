<?php

namespace UserAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use UserAuthBundle\Entity\Advert;

class ApiAdvertsController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/advertsapi")
     */
    public function getAdvertsAction(Request $request)
    {
        $adverts = $this->get('doctrine.orm.entity_manager')
            ->getRepository('UserAuthBundle:Advert')
            ->findAll();
        /* @var $places advert[] */

        // Création d'une vue FOSRestBundle
        $view = View::create($adverts);
        $view->setFormat('json');

        return $view;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/advertsapi/{id}")
     */
    public function getAdvertAction(Request $request)
    {
        $adverts = $this->get('doctrine.orm.entity_manager')
            ->getRepository('UserAuthBundle:Advert')
            ->find($request->get('id'));
        /* @var $places advert[] */

        // Création d'une vue FOSRestBundle
        $view = View::create($adverts);
        $view->setFormat('json');

        return $view;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/advertsapi")
     */
    public function postAdvertAction(Request $request)
    {
        /*return [
            'adverts' => [
                $request->get('title'),
                $request->get('description')
            ]
        ];*/

        $advert = new Advert();
        $advert->setTitle($request->get('title'))
            ->setDescription($request->get('description'))
            ->setPrice($request->get('price'));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($advert);
        $em->flush();

        return $advert;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/adverts/{id}")
     */
    public function removeAdvertAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $place = $em->getRepository('UserAuthBundle:Advert')
            ->find($request->get('id'));
        /* @var $place Place */

        $em->remove($place);
        $em->flush();
    }
}

?>