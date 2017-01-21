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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

class DefaultController extends BaseController
{
    /**
     * @Get("/")
     */
    public function indexAction()
    {
        $view = $this->view(['version' => '1.0', 'status' => 'Working'], Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Get("/version")
     */
    public function versionAction()
    {
        $view = $this->view(['version' => '1.0'], Response::HTTP_OK);
        return $this->handleView($view);
    }
}
