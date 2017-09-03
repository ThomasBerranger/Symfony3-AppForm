<?php
/**
 * Created by PhpStorm.
 * User: tberr
 * Date: 02/09/2017
 * Time: 14:51
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
        //création produit
        $product = new Product();

        //création frm grâce à le classe
        $form = $this->createForm(ProductType::class, $product);

        //récupération des données
        $form->handleRequest($request);

        //si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {
            //on enregistre le produit en bdd
            $em = $this->getDoctrine()->getManager();

            //préparation de l'entity manager à l'insertion
            $em->persist($product);

            //on envoie les données
            $em->flush();

            return new Response('Produit ajouté');
        }

        //création de la vue du formulaire
        $formView = $form->createView();

        //on return la vue
        return $this->render('add.html.twig', array('form' => $formView));
    }

    /**
     * @Route("/list", name="list")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');

        $product = $repository->findAll();

        return $this->render('list.html.twig', array(
            'products' => $product
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editAction(Request $request, Product $product, $id)
    {


        //création frm grâce à le classe
        $form = $this->createForm(ProductType::class, $product);

        //récupération des données
        $form->handleRequest($request);

        //si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {
            //on enregistre le produit en bdd
            $em = $this->getDoctrine()->getManager();

            //inutile dans un update
            //$em->persist($product);

            //on envoie les données
            $em->flush();

            return new Response('Produit modifié');
        }

        //création de la vue du formulaire
        $formView = $form->createView();

        //on return la vue
        return $this->render('add.html.twig', array('form' => $formView));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new Response('Produit supprimé');
    }
}