<?php

namespace UserAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;

class ConfigController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($session->get('userRole') != 'admin')
            return $this->render("UserAuthBundle:Error:503.html.twig");
        if($request->isMethod("POST"))
        {
            $yaml = Yaml::parse(file_get_contents($this->container->get('kernel')->getRootDir() .'/config/parameters.yml'));

            $yaml['parameters']['database_host'] = $request->get("host");
            $yaml['parameters']['database_port'] = $request->get("port");
            $yaml['parameters']['database_name'] = $request->get("name");
            $yaml['parameters']['database_user'] = $request->get("user");
            $yaml['parameters']['database_password'] = $request->get("password");

            $new_yaml = Yaml::dump($yaml, 5);
            file_put_contents($this->container->get('kernel')->getRootDir() .'/config/parameters.yml', $new_yaml);

            return $this->render('UserAuthBundle:Home:index.html.twig');
        }
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

    public function exportAction()
    {
        $yaml = file_get_contents($this->container->get('kernel')->getRootDir() .'/config/parameters.yml');

        return new Response($yaml, 200, array(
            'Content-Type' => 'application/x-yaml',
            'Content-Disposition' => 'attachment; filename="parameters.yml"'
        ));
    }
}
?>