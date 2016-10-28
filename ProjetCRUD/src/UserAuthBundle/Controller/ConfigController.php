<?php

namespace UserAuthBundle\Controller;

use UserAuthBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConfigController extends Controller
{
    public function indexAction()
    {
        //$repository = $this->getDoctrine()->getManager()->getRepository('UserAuthBundle:Advert');
        //$listAdverts = $repository->FindAll();

        return $this->render('UserAuthBundle:Config:index.html.twig');/*,
            array(
                'listAdverts' => $listAdverts,
            )
        );*/
    }
}
?>