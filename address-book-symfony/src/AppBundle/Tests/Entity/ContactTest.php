<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Company;
use AppBundle\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    /**
     * @var Contact
     */
    protected $contact;

    public function setUp()
    {
        $this->contact = new Contact();
    }

    public function tearDown()
    {

    }

    public function testHello() {
        $this->assertEquals(3, 1 + 2);
    }

    /*
    public function testHelloFail() {
        $this->assertEquals(1, 1 + 2, '1 + 2 pas le résultat attendu');
    }
    */

    public function testConstructorWithoutParams() {
        $this->assertNull($this->contact->getCompany());
        $this->assertNull($this->contact->getId());
        $this->assertNull($this->contact->getEmail());
        $this->assertNull($this->contact->getFirstName());
        $this->assertNull($this->contact->getLastName());
        $this->assertNull($this->contact->getTelephone());
    }

    public function testGetSetFirstName() {
        $firstName = 'Romain';
        $this->contact->setFirstName($firstName);
        $this->assertEquals($firstName, $this->contact->getFirstName());
    }

    public function testIntegrationWithCompany() {
        $company = new Company();
        $company->setName('Acme');

        $this->contact->setCompany($company);
        $this->assertEquals(
            'Acme',
            $this->contact->getCompany()->getName()
        );
    }
}
