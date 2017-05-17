<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * Home page
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
        $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
        /**
         * @var $users \Application\Entity\User
         */
        $users = $em->getRepository('Application\Entity\User')
            ->findAll();

        return new ViewModel([
            'users' => $users
        ]);
    }
}
