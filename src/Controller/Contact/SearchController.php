<?php

namespace App\Controller\Contact;

use App\Controller\AbstractSimplecController;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractSimplecController
{
    protected $em;
    protected $contactlists;
    public function __construct(EntityManagerInterface $em, ContactRepository $contactlists)
    {
        $this->em = $em;
        $this->contactlists = $contactlists;
    }


    /**
     * @Route("/contact/ajax", name="app_contact_search")
     */
    public function index(Request $request): Response
    {
        if($this->isFullyLoggedIn()){
            $contacts = $this->contactlists->findAll();
            if ($request->isXmlHttpRequest() && $request->request->get('search_keywords') != '') {  
                $contacts = $this->contactlists->findByName($request->request->get('search_keywords'));
            }


            $jsonData = array();  
            $idx = 0;  
            foreach($contacts as $contact) {  
               $temp = array(
                    'id' => $contact->getId(),  
                  'first_name' => $contact->getFirstName(),  
                  'last_name' => $contact->getLastName(),  
                  'mobile' => $contact->getMobile(),  
                  'email' => $contact->getEmail(),  
                  'city' => $contact->getCity(),  
                  'is_active' => $contact->getIsActive(),  
               );   
               $jsonData[$idx++] = $temp;  
            } 

           return new JsonResponse( $jsonData);
            // return $contacts;
        }
        return $this->redirectToRoute('app_login');
    }
}
