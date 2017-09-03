<?php
/**
 * Created by PhpStorm.
 * User: tberr
 * Date: 03/09/2017
 * Time: 11:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * @Route("/category/add", name="addCategory")
     */
    public function addAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new Response('Cétegorie ajoutée');
        }

        $formView = $form->createView();

        return $this->render('category.html.twig', array(
            'form' => $formView
        ));
    }
}