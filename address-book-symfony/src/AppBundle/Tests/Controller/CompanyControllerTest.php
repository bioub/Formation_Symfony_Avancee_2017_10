<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Company;
use AppBundle\Manager\CompanyManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $companies = [
            (new Company())->setId(1)->setName('PLB')
        ];

        $managerMock = $this->prophesize(CompanyManager::class);
        $managerMock->getList()->willReturn($companies)
                    ->shouldBeCalledTimes(2);

        // TODO deprecated
        $client->getContainer()->set(CompanyManager::class, $managerMock->reveal());

        $crawler = $client->request('GET', '/company/');

        // Faire des assertions ici sur le status code et le contenu
        // Refaire la meme chose pour testShow ci-dessous
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(
            1,
            $crawler->filter('table tbody tr')
        );
        $this->assertContains(
            'PLB',
            $crawler->filter('table tbody tr td:first-child')->text()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $company = (new Company())->setId(1)->setName('PLB');

        $managerMock = $this->prophesize(CompanyManager::class);
        $managerMock->getList()->willReturn([])->shouldBeCalledTimes(1);
        $managerMock->getById(1)->willReturn($company)
            ->shouldBeCalledTimes(1);

        // TODO deprecated
        $client->getContainer()->set(CompanyManager::class, $managerMock->reveal());

        $crawler = $client->request('GET', '/company/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains(
            'PLB',
            $crawler->filter('h2')->text()
        );
    }

}
