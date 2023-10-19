<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractSimplecController
{

    protected $em;
    protected $contactlists;
    public function __construct(EntityManagerInterface $em, ContactRepository $contactlists)
    {
        $this->em = $em;
        $this->contactlists = $contactlists;
    }
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {
        if($this->isFullyLoggedIn()){
            $contacts = $this->contactlists->findAll();
            return $this->render('dashboard/index.html.twig', [
                'contacts' => $contacts,
            ]);
        }

        return $this->redirectToRoute('app_login');
    }
}
