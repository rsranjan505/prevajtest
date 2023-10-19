<?php

namespace App\Controller\Contact;

use App\Controller\AbstractSimplecController;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Role\Role;

class EditController extends AbstractSimplecController
{

    protected $em;
    protected $contactlist;

    public function __construct(EntityManagerInterface $em,ContactRepository $contactlist)
    {
        $this->em = $em;
        $this->contactlist = $contactlist;
    }
    

    /**
     * @Route("/contact-edit/{id}", name="app_contact_edit")
     */
    public function index($id, Request $request): Response
    {
        if($this->isFullyLoggedIn()){
            $contact = $this->contactlist->find($id);

            $form = $this->createForm(ContactType::class, $contact);
    
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                
                $contact->setName($form->get('name')->getData());
                $contact->setMobile($form->get('mobile')->getData());
                $contact->setEmail($form->get('email')->getData());
                $contact->setCity($form->get('city')->getData());
    
               $this->em->flush(); 
    
               return $this->redirectToRoute('app_contact');
            
            }
            
            return $this->render('contact/edit.html.twig', [
                'contact'=> $contact,
                'form' => $form->createView()
            ]);    
        }
       
        return $this->redirectToRoute('app_login');

    }
}
