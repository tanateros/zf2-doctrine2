<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Application\Entity\User;

/**
 * Class ApiController
 * @package Application\Controller
 */
class ApiController extends AbstractActionController
{
    /**
     * Create user
     *
     * Method: POST
     * Request params: name (string, mandatory), fullname (string, mandatory), email (string, mandatory), telephone (string), address (string)
     * Responce good (JSON) keys: massage (always)
     * Responce wrong (JSON) keys: massage (always)
     *
     * @return JsonModel
     */
    public function createAction()
    {
        $inputData = json_decode($this->getRequest()->getContent(), 1);
        
        if ((!empty($inputData)) && (!empty($inputData['name'])) && (!empty($inputData['fullname'])) && (!empty($inputData['email']))) {
            $userEntity = new User();
            $userEntity->exchangeArray($inputData);
            /**
             * @var $em \Doctrine\ORM\EntityManager
             */
            $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
            $em->persist($userEntity);
            $em->flush();

            $result = [
                'message' => "add new row #{$userEntity->getId()}"
            ];
        } else {
            $result = [
                'message' => "Wrong data"
            ];
        }

        return new JsonModel($result);
    }

    /**
     * Read user
     *
     * Method: GET
     * Request params: id (int, mandatory)
     * Responce good (JSON) keys: massage (always)
     * Responce wrong (JSON) keys: massage (always)
     *
     * @return JsonModel
     */
    public function readAction()
    {
        if (!empty($id = (int)$this->params()->fromRoute('id'))) {
            /**
             * @var $em \Doctrine\ORM\EntityManager
             */
            $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
            /**
             * @var $user \Application\Entity\User
             */
            $user = $em->getRepository('Application\Entity\User')
                ->findBy(array('id' => $id));
            if (!isset($user[0])) {
                $result = [
                    'message' => 'User not found'
                ];
            } else {
                $result = [
                    'message' => 'user: ' . json_encode($user[0]->toArray())
                ];
            }
        } else {
            $result = [
                'message' => "Wrong data"
            ];
        }

        return new JsonModel($result);
    }

    /**
     * Update user
     *
     * Method: PUT
     * Request params: id (int, mandatory, information: this param need add to URI)
     * Responce good (JSON) keys: massage (always)
     * Responce wrong (JSON) keys: massage (always)
     *
     * @return JsonModel
     */
    public function updateAction()
    {
        if($_SERVER['REQUEST_METHOD'] == 'PUT' && !empty($id = (int)$this->params()->fromRoute('id'))) {
            $putData = file_get_contents('php://input');
            $explodedData = json_decode($putData);
            /**
             * @var $em \Doctrine\ORM\EntityManager
             */
            $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
            /**
             * @var $user \Application\Entity\User
             */
            $user = $em->getRepository('Application\Entity\User')
                ->find(array('id' => $id));
            if (empty($user)) {
                $result = [
                    'message' => 'User not found'
                ];
            } else {
                $user->exchangeArray($explodedData);

                $em->persist($user);
                $em->flush();

                $result = [
                    'message' => "update row #{$id}"
                ];
            }
        } else {
            $result = [
                'message' => "Wrong data"
            ];
        }

        return new JsonModel($result);
    }

    /**
     * Delete user
     *
     * Method: DELETE
     * Request params: id (int, mandatory, information: this param need add to URI)
     * Responce good (JSON) keys: massage (always)
     * Responce wrong (JSON) keys: massage (always)
     *
     * @return JsonModel
     */
    public function deleteAction()
    {
        if($_SERVER['REQUEST_METHOD'] == 'DELETE' && !empty($id = (int)$this->params()->fromRoute('id'))) {
            /**
             * @var $em \Doctrine\ORM\EntityManager
             */
            $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
            /**
             * @var $user \Application\Entity\User
             */
            $user = $em->getRepository('Application\Entity\User')
                ->find(array('id' => $id));
            if (empty($user)) {
                $result = [
                    'message' => 'User not found'
                ];
            } else {
                $em->remove($user);
                $em->flush();

                $result = [
                    'message' => "remove user id #{$id}"
                ];
            }
        } else {
            $result = [
                'message' => "Wrong data"
            ];
        }

        return new JsonModel($result);
    }
}
