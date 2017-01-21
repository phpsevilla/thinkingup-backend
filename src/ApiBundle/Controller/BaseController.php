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

use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * Class BaseController
 * @package ApiBundle\Controller
 */
class BaseController extends FOSRestController
{
    /**
     * Método para validar los parámetros del request, creando un formulario con el nombre indicado,
     * devolviéndolo en caso de validar bien, o lanzando una excepción en caso contrario
     *
     * @param $formName
     * @param $errors
     * @param $data
     * @return \Symfony\Component\Form\Form
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    protected function validateRequest($formName, &$errors = null, $data = null)
    {
        //Utilizamos un formulario de symfony para simplificar la gestión de validaciones de los datos de entrada
        //y la creación de una entidad/documento independientemente de la BD usada, con los datos rellenos,
        //incluyendo el enlace con el comentario al que se replica, si es necesario
        $form = $this->createForm($formName, $data);

        //El bundle FOSRestBundle ya nos da los parámetros que se hayan informado por json como un array
        //Permitimos que los parámetros vengan en plano o colgando de un 'nodo' con el valor del nombre del form
        $request = $this->getRequest()->request;

        $name = $form->getName();

        if (!$request->has($name)) {
            $params = $request->all();
        } else {
            $params = $request->get($name);
        }

        //Con este método se realizan las validaciones y se crea un objeto/entidad/documento del tipo que sea
        $form->submit($params);

        //Si no es válido, se lanza una excepción para devolver un error HTTP 4000 Bad Request
        //y se actualiza el valor de $error.
        //Si en el método "llamante" se quiere hacer otro tratamiento de errores, se puede capturar la excepción
        //y comprobar el valor de $error para otras gestiones
        if (!$form->isValid()) {
            $errors = $form->getErrors();
            throw new HttpException(Codes::HTTP_BAD_REQUEST);
        } else {
            //Si todo va bien, se devuelve el objeto creado por el formulario
            return $form->getData();
        }
    }
}
