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

class AdvertController extends Controller
{
    public function indexAction()
    {
    	$repository = $this->getDoctrine()->getManager()->getRepository('UserAuthBundle:Advert');
  		$listAdverts = $repository->FindAll();

	    return $this->render('UserAuthBundle:Advert:index.html.twig', array(
	      'listAdverts' => $listAdverts,
	    ));
    }

    public function deleteAction(Request $request)
    {
        /*if($request->isXmlHttpRequest()) {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UserAuthBundle:Advert');
        $advert = $repository->find($request->get('id'));*/

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UserAuthBundle:Advert');
        $advert = $repository->find($request->get("idAdvert"));

        $em->remove($advert);
        $em->flush();
        //return new JsonResponse(array('id' => $request->get('id')));
        return $this->redirectToRoute('advert_admin_index');
    	//}
    }

    public function createOrEditAction($id = null, Request $request)
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	if($id == null)
    		$advert = new Advert();
    	else
    	{
	    	$repository = $entityManager->getRepository('UserAuthBundle:Advert');
			$advert = $repository->find($id);
    	}
    	
    	$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

    	$formBuilder
    		->add('title', TextType::class, array('required' => true))
			->add('description', TextType::class, array('required' => true))
			->add('price', TextType::class, array('required' => true))
			->add('save', SubmitType::class);
		$form = $formBuilder->getForm();

    	if ($request->isMethod('POST')) 
    	{
    		$form->handleRequest($request);
    		if ($form->isValid()) 
    		{
                $advert->setPrice(str_replace(',','.',$advert->getPrice()));
                //number_format($number, 2, ',', ' ');
    			$entityManager->persist($advert);
    			$entityManager->flush();
    		}
	    	return $this->redirectToRoute('advert_admin_index');
    	}
    	return $this->render('UserAuthBundle:Advert:CreateOrEdit.html.twig', array(
    		'form' => $form->createView() ));
    }


}
