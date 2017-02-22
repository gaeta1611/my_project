<?php

namespace projectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use projectBundle\Entity\note;
use projectBundle\Entity\categorie;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
    	$em = $this->getDoctrine()->getManager();

    	$product = $em->getRepository('projectBundle:note')->findAll();

        return $this->render('projectBundle:Note:index.html.twig', array('notes' => $product));
    }

    /**
     *@Route("/newNote", name="newNote")
     */
	public function createNoteAction(Request $request) {  
    	$task = new note();

    	$em = $this->getDoctrine()->getManager();

    	$categories = $em->getRepository('projectBundle:categorie')->findAll();


		$form = $this->createFormBuilder($task) 
			->add('title', TextType::class, array('label' => 'Titre : ')) 
			->add('content', TextType::class, array('label' => 'Contenu : ')) 
			->add('categorie', ChoiceType::class, array('label' => 'Catégorie : ', 
				'choices'=>$categories,
				'choice_label' => function($cat, $key, $index) {
					return $cat->getNom();
				}))
			->add('save', SubmitType::class, array('label' => 'Sauvegarder')) 
			->getForm();

		$form->handleRequest($request); 
		$task = $form->getData();

		if ($form->isValid()) { 
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($task); 
			$em->flush(); 

			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('projectBundle:Note:note.html.twig', array('form' =>$form->createView()));
	}


	public function modifyNoteAction(Request $request, note $task) {  
    	$em = $this->getDoctrine()->getManager();

    	$categories = $em->getRepository('projectBundle:categorie')->findAll();


		$form = $this->createFormBuilder($task) 
			->add('title', TextType::class, array('label' => 'Titre : ')) 
			->add('content', TextType::class, array('label' => 'Contenu : ')) 
			->add('categorie', ChoiceType::class, array('label' => 'Catégorie : ', 
				'choices'=>$categories,
				'choice_label' => function($cat, $key, $index) {
					return $cat->getNom();
				}))
			->add('save', SubmitType::class, array('label' => 'Sauvegarder')) 
			->getForm();

		$form->handleRequest($request); 
		$task = $form->getData();

		if ($form->isValid()) { 
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($task); 
			$em->flush(); 

			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('projectBundle:Note:index.html.twig', array('form' =>$form->createView()));
	}

	/**
     *@Route("/newCategorie", name="newCategorie")
     */
	public function createCategorieAction(Request $request) { 
		$task = new categorie();

		$form = $this->createFormBuilder($task) 
			->add('nom', TextType::class, array('label' => 'Nom de la catégorie')) 
			->add('save', SubmitType::class, array('label' => 'Sauvegarder')) 
			->getForm();

		$form->handleRequest($request); 
		$task = $form->getData();

		if ($form->isValid()) { 
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($task); 
			$em->flush(); 

			return $this->redirect($this->generateUrl('home'));
		}

		return $this->render('projectBundle:Note:create_categorie.html.twig', array('form' =>$form->createView()));
	}

	/**
     * @Route("/ShowCategorie", name="ShowCategorie")
     */
    public function showCategorie() {
    	$em = $this->getDoctrine()->getManager();

    	$product = $em->getRepository('projectBundle:categorie')->findAll();

        return $this->render('projectBundle:Note:ShowCategorie.html.twig', array('categories' => $product));
    }

    /**
     * @Route("/deleteCategorie/{id}", name="deleteCategorie")
     */
    public function deleteCategorie(categorie $categorie) {
    	$em = $this->getDoctrine()->getManager();

    	$product = $em->getRepository('projectBundle:categorie')->find($categorie);

    	$em->remove($product);
    	$em->flush();

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/deleteNote/{id}", name="deleteNote")
     */
    public function deleteNote(note $note) {
    	$em = $this->getDoctrine()->getManager();

    	$product = $em->getRepository('projectBundle:note')->find($note);

    	$em->remove($product);
    	$em->flush();

        return $this->redirect($this->generateUrl('home'));
    }


}
