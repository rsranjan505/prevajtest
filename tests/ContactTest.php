<?php

namespace App\Tests;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactTest extends KernelTestCase
{
        /** @var EntityManagerInterface */
        private $entityManager;

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
        public function test_contact_record_created_in_database()
        {

            //first check if exist
            $contactRepo = $this->entityManager->getRepository(Contact::class);
            $contact = $contactRepo->findOneBy(['name' => 'herry']);
            if($contact){
                $this->entityManager->remove($contact);
                $this->entityManager->flush();
            }
    
            $contact = new Contact();
            $contact->setName('herry');
            $contact->setMobile('7004857557');
            $contact->setEmail('contact123@gmail.com');
            $contact->setCity('patna');
            $contact->setCreatedAt(new \Datetime('now'));
            $contact->setUpdatedAt(new \Datetime('now'));
    

            $this->entityManager->persist($contact);
            $this->entityManager->flush();
    
            $contactRepo = $this->entityManager->getRepository(Contact::class);
            $contact = $contactRepo->findOneBy(['name' => 'herry']);
    
            // Make assertion
            $this->assertEquals('7004857557',$contact->getMobile());
            $this->assertEquals('contact@gmail.com',$contact->getEmail());
            $this->assertEquals('patna',$contact->getCity());
            $this->assertTrue(true);
        }
}