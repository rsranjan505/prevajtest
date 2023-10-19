<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    protected $em;
    protected $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function index(): Response
    {
        return $this->render('security/register.html.twig');
    }

        /**
     * @Route("/save_user", name="register_save")
     */
    public function user_register(Request $request){

        $user = new User();
        $data = $request->request->all();

        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
        $user->setCreatedAt(new \Datetime('now'));
        $user->setUpdatedAt(new \Datetime('now'));

        $plaintextPassword  = $data['password'];
        
        $hashpassword = $this->encoder->encodePassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashpassword);

        $this->em->persist($user);
        $this->em->flush();
      
        return $this->redirectToRoute('app_login');

    }
}
