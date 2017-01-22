<?php

/*
 * This file is part of the Thinkingup project.
 *
 * (c) Miguel Ángel Martín <miguelbemartin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Controller;

use ApiBundle\Entity\Idea;
use ApiBundle\Form\IdeaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;

/**
 * Idea controller.
 *
 * @package ApiBundle\Controller
 */
class IdeaController extends BaseController
{
    /**
     * @Rest\Get("/ideas")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIdeas()
    {
        $em = $this->getDoctrine()->getManager();

        $ideas = $em->getRepository('ApiBundle:Idea')->findAll();

        $view = $this->view($ideas, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/ideas/{id}")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIdea($id)
    {
        $em = $this->getDoctrine()->getManager();

        $idea = $em->getRepository('ApiBundle:Idea')->find($id);

        $view = $this->view($idea, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/ideas")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postIdea(Request $request)
    {
        $idea = new Idea();
        $form = $this->createForm('ApiBundle\Form\IdeaType', $idea);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            $idea->setUser($user);

            $em->persist($idea);

            $em->flush();

            $view = $this->view($idea, Response::HTTP_OK);

            return $this->handleView($view);

      }else{
          return  ['data' => $form];
      }
    }
}
