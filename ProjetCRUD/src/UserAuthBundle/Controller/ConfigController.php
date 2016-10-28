<?php

namespace UserAuthBundle\Controller;

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
        $datas = array();

        $datas['host'] = $this->container->getParameter('database_host');
        $datas['port'] = $this->container->getParameter('database_port');
        $datas['name'] = $this->container->getParameter('database_name');
        $datas['user'] = $this->container->getParameter('database_user');
        $datas['password'] = $this->container->getParameter('database_password');

        return $this->render('UserAuthBundle:Config:index.html.twig',
            array(
                'datas' => $datas
            )
        );
    }
}
?>