<?php

namespace UserAuthBundle\Controller;

use UserAuthBundle\Entity\User;
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

class HomeController extends Controller
{
    public function indexAction()
    {
    	/*$serviceConnexion = $this->get('user_auth.UserAuthService');
    	if($serviceConnexion->isConnecter())
    		throw new \Exception('Vous êtes connecté !');*/
    	$entityManager = $this->getDoctrine()->getManager();
    	$userRepository = $entityManager->getRepository('UserAuthBundle:User');

        return $this->render('UserAuthBundle:Home:index.html.twig');
    }

    public function logoutAction(Request $request)
    {
    	$session = $request->getSession();
    	$session->set('user', '');
    	return $this->render('UserAuthBundle:Home:index.html.twig');
    	return $this->redirect($this->generateUrl('UserAuthBundle_home_index'));
    }
    public function loginAction(Request $request)
    {
    	if($request->isXmlHttpRequest()) {
    		$email = $request->get('email');
    		$password = $request->get('password');
    		$repository = $this->getDoctrine()->getManager()
    				->getRepository('UserAuthBundle:User');
			$userPost = $repository->FindByEmail($email);
			if($userPost === null){
				throw new NotFoundHttpException("Cette utilisateur n'existe pas !");
			}
			$this->get('logger')->info($userPost[0]->getPassword().' -- '.$password);
		    if (password_verify($password, $userPost[0]->getPassword())) {
		        $session = $request->getSession();
				$session->set('user', $userPost[0]->getId());
                $session->set('userRole', $userPost[0]->getRole());

				return new JsonResponse(array('name' => $userPost[0]->getId()));
		    } else {
		        throw new NotFoundHttpException("Mot de passe incorrecte");
		    }
    	}
    }

    public function inscriptionAction(Request $request)
    {
    	$user = new User();
    	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

    	$formBuilder
    		->add('name', TextType::class, array('required' => true))
			->add('email', TextType::class, array('required' => true))
			->add('password', PasswordType::class, array('required' => true))
			->add('phone', TextType::class, array('required' => false))
			->add('save', SubmitType::class);
		$form = $formBuilder->getForm();

    	if ($request->isMethod('POST')) 
    	{
    		$form->handleRequest($request);
    		if ($form->isValid()) 
    		{
				$password = password_hash($user->getPassword(),PASSWORD_BCRYPT/*, ["cost" => 12]*/);
            	$user->setPassword($password);

				$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->persist($user);
    			$entityManager->flush();

				$session = $request->getSession();
				$session->set('user', $user->getId());
                $session->set('userRole', $user->getRole());
    		}
	    	return $this->render('UserAuthBundle:Home:index.html.twig');
    	}
    	return $this->render('UserAuthBundle:Home:inscription.html.twig', array(
    		'form' => $form->createView() ));
    }
}
