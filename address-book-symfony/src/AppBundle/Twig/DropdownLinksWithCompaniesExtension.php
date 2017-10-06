<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 06/10/2017
 * Time: 13:54
 */

namespace AppBundle\Twig;


use AppBundle\Manager\CompanyManager;

class DropdownLinksWithCompaniesExtension extends \Twig_Extension
{
    /**
     * @var CompanyManager
     */
    protected $companyManager;

    /**
     * DropdownLinksWithCompaniesExtension constructor.
     * @param CompanyManager $companyManager
     */
    public function __construct(CompanyManager $companyManager)
    {
        $this->companyManager = $companyManager;
    }


    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('dropdownLinksWithCompanies', [$this, 'dropdownLinksWithCompanies'], [
                'is_safe' => ['html' => true]
            ])
        ];
    }

    public function dropdownLinksWithCompanies()
    {
        $companies = $this->companyManager->getList();

        $html = '';

        foreach ($companies as $c) {
            $html .= "<a class=\"dropdown-item\" href=\"#\">{$c->getName()}</a>";
        }

        return $html;
    }
}
