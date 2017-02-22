<?php

namespace projectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use projectBundle\Entity\note;
use projectBundle\Entity\categorie;
use Symfony\Component\HttpFoundation\JsonResponse;



class APIController extends Controller
{
    /**
     * @Route("/api/categorie")
     * @Method("GET")
     */
    public function getCategoriesAction() {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('projectBundle:categorie')->findAll();

        $serializer = $this->get('serializer');
        return new JsonResponse($serializer->serialize($categorie, 'json'));
    }

    /**
     * @Route("/api/note")
     * @Method("GET")
     */
    public function getNotesAction() {
        $em = $this->getDoctrine()->getManager();
        $note = $em->getRepository('projectBundle:note')->findAll();

        $serializer = $this->get('serializer');
        return new JsonResponse($serializer->serialize($note, 'json'));
    }

    /**
     * @Route("/api/categorie/{id}")
     * @Method("GET")
     */
    public function getCategorieAction(categorie $cat) {
        $serializer = $this->get('serializer');
        return new JsonResponse($serializer->serialize($cat, 'json'));
    }

    /**
     * @Route("/api/note/{id}")
     * @Method("GET")
     */
    public function getNoteAction(note $note) {
        $serializer = $this->get('serializer');
        return new JsonResponse($serializer->serialize($note, 'json'));
    }

    /**
     * @Route("/api/categorie/{id}")
     * @Method("PUT")
     */
    public function updateCategorieAction(Request $request, categorie $cat) {
        $data = json_decode($request->getContent(), true);
        $cat->setNom($data['nom']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cat);
        $em->flush();
        return new Response();
      }

     /**
      * @Route("/api/note/{id}")
      * @Method("PUT")
      */
      public function updateNoteAction(Request $request, note $note) {
          $data = json_decode($request->getContent(), true);
          $em = $this->getDoctrine()->getManager();
          $cat = $em->getRepository('projectBundle:categorie')->find($data['categorie']);
          $note->setTitle($data['title']);
          $note->setContent($data['content']);
          $note->setCategorie($cat);

          $em = $this->getDoctrine()->getManager();
          $em->persist($note);
          $em->flush();
          return new Response();
      }

     /**
      * @Route("/api/categorie")
      * @Method("POST")
      */
     public function newCategorieAction(Request $request) {
         $cat = new categorie;
         return $this->updateCategorieAction($request, $cat);
     }

     /**
      * @Route("/api/note")
      * @Method("POST")
      */
     public function newNoteAction(Request $request) {
         $note = new note;
         return $this->updateNoteAction($request, $note);
     }

     /**
       * @Route("/api/categorie/{id}")
       * @Method("DELETE")
       */
       public function deleteCategorieAction(Request $request, categorie $cat) {
           $em = $this->getDoctrine()->getManager();
           $task = $em->getRepository('projectBundle:categorie')->find($cat);
           $em->remove($task);
           $em->flush();
           return new Response();
       }

       /**
       * @Route("/api/note/{id}")
       * @Method("DELETE")
       */
       public function deleteNoteAction(Request $request, note $note) {
           $em = $this->getDoctrine()->getManager();
           $task = $em->getRepository('projectBundle:note')->find($note);
           $em->remove($task);
           $em->flush();
           return new Response();
       }
   

}
