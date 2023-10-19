<?php

namespace App\Controller\Contact;

use App\Controller\AbstractSimplecController;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractSimplecController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/contact-add", name="app_contact_add")
     */
    public function index(Request $request)
    {
        if($this->isFullyLoggedIn()){
            $contact = new Contact();

            $form = $this->createForm(ContactType::class, $contact);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) { 
                
                $newcontact = $form->getData();
    
                $contact->setCreatedAt(new \Datetime('now'));
                $contact->setUpdatedAt(new \Datetime('now'));
                $this->em->persist($newcontact);
                $this->em->flush();
    
                return $this->redirectToRoute('app_contact');
            }
    
            return $this->render('contact/create.html.twig',[
                'form' => $form->createView()
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

}
