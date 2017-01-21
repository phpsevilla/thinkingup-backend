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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Util\Codes;

/**
 * Idea controller.
 *
 * @package ApiBundle\Controller
 */
class IdeaController extends BaseController
{
    /**
     * @Get("/idea")
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
     * @Get("/idea/{id}")
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
}
