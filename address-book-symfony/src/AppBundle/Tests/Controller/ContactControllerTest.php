<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Repository\ContactRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function setUp() {
        // TODO reimporter un dump
        // fichier SQL
        // DoctrineDataFixture
        // Alice / Faker
    }

    public function testList()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $registryMock = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repoMock = $this->getMockBuilder(ContactRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repoMock->expects($this->once())
            ->method('findAll')
            ->willReturn([
                (new Contact())->setId(1)->setFirstName('A')->setLastName('B'),
                (new Contact())->setId(2)->setFirstName('C')->setLastName('D'),
            ]);

        $registryMock->expects($this->once())
                ->method('getRepository')
                ->willReturn($repoMock);

        $container->set('doctrine', $registryMock);

        $crawler = $client->request('GET', '/contacts/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


        $this->assertEquals(
            'Contact List',
            $crawler->filter('h2')->text()
        );
        $this->assertCount(
            2,
            $crawler->filter('table tbody tr')
        );
    }

    public function testAdd()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/contacts/add');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->filter('form')->form([
            'app_contact[firstName]' => 'Mark',
            'app_contact[lastName]' => 'Zuckerberg',
        ]);
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            'http://localhost/contacts/',
            $client->getRequest()->getUri()
        );
    }

    // Attention ce test dépend de la DB, si c'est ce qu'on veut
    // importer un dump dans setUp
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contacts/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            'Bill Gates',
            $crawler->filter('h2')->text()
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contacts/{id}/update');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contacts/{id}/delete');
    }

}
