<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTest extends KernelTestCase
{
        /** @var EntityManagerInterface */
        private $entityManager;

        /** @var UserPasswordEncoderInterface */
        protected $encoder;
        
    
        public function setUp(): void
        {
            $kernel = self::bootKernel();
    
            DataBasePrimer::prime(self::$kernel);
    
            $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        }

        protected function tearDown(): void
        {
            parent::tearDown();
            $this->entityManager->close();
            $this->entityManager = null;
        }
    
    
        /** 
         * @var test 
         */
        public function test_user_record_created_in_database()
        {
    
            $user = new User();
    
            $user->setFirstName('tom');
            $user->setLastName('cruise');
            $user->setEmail('tom@gmail.com');
            $user->setCreatedAt(new \Datetime('now'));
            $user->setUpdatedAt(new \Datetime('now'));
    
            // $hashpassword = $this->encoder->encodePassword(
            //     $user,
            //     '12345678'
            // );
            $user->setPassword('12345678');
    
            $this->entityManager->persist($user);
            $this->entityManager->flush();
    
            $userRepo = $this->entityManager->getRepository(User::class);
            $user = $userRepo->findOneBy(['email' => 'tom@gmail.com']);
    
            // Make assertion
            $this->assertEquals('tom',$user->getFirstName());
            $this->assertEquals('cruise',$user->getLastName());
            $this->assertTrue(true);
        }
}