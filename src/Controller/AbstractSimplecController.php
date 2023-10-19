<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class AbstractSimplecController extends AbstractController
{
   
    /** @var Request */
    protected $request;
    protected $requestStack;

    protected $security;
    public function __construct(Security $security, RequestStack $requestStack)
    {
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

         /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
       
    }

    protected function isFullyLoggedIn(): bool
    {
       
        return $this->isGranted('IS_AUTHENTICATED_FULLY');
    }

    public function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

}
