<?php

namespace App\Controller\Contact;

use App\Controller\AbstractSimplecController;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractSimplecController
{
    protected $em;
    protected $contactlists;
    public function __construct(EntityManagerInterface $em, ContactRepository $contactlists)
    {
        $this->em = $em;
        $this->contactlists = $contactlists;
    }


    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(): Response
    {
        if($this->isFullyLoggedIn()){
            $contacts = $this->contactlists->findAll();
            return $this->render('contact/index.html.twig', [
                'contacts' => $contacts,
            ]);
        }
        return $this->redirectToRoute('app_login');
    }
}
