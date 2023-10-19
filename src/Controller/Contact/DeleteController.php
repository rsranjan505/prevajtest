<?php

namespace App\Controller\Contact;

use App\Controller\AbstractSimplecController;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractSimplecController
{
    protected $em;
    protected $contactlist;

    public function __construct(EntityManagerInterface $em,ContactRepository $contactlist)
    {
        $this->em = $em;
        $this->contactlist = $contactlist;
    }

     /**
     * @Route("/contact-delete/{id}", name="app_contact_delete")
     */
    public function index($id): Response
    {
        if($this->isFullyLoggedIn()){
            $contact = $this->contactlist->find($id);

            $this->em->remove($contact);
            $this->em->flush();
    
            return $this->redirectToRoute('app_contact');
        }
        return $this->redirectToRoute('app_login');
    }
}
