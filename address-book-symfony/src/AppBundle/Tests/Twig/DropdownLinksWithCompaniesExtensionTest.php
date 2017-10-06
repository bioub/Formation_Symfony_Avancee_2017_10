<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 06/10/2017
 * Time: 14:00
 */

namespace AppBundle\Tests\Twig;


use AppBundle\Entity\Company;
use AppBundle\Manager\CompanyManager;
use AppBundle\Twig\DropdownLinksWithCompaniesExtension;
use PHPUnit\Framework\TestCase;

class DropdownLinksWithCompaniesExtensionTest extends TestCase
{
    public function testDropdownLinksWithCompanies()
    {
        $companies = [
            (new Company())->setId(1)->setName('PLB')
        ];

        $managerMock = $this->prophesize(CompanyManager::class);
        $managerMock->getList()
            ->willReturn($companies)
            ->shouldBeCalledTimes(1);

        $extension = new DropdownLinksWithCompaniesExtension($managerMock->reveal());

        $this->assertEquals(
            '<a class="dropdown-item" href="#">PLB</a>',
            $extension->dropdownLinksWithCompanies()
        );
    }
}
