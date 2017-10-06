<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Manager\CompanyManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CompanyController extends Controller
{
    /**
     * @var CompanyManager
     */
    protected $companyManager;

    /**
     * CompanyController constructor.
     * @param CompanyManager $companyManager
     */
    public function __construct(CompanyManager $companyManager)
    {
        $this->companyManager = $companyManager;
    }


    /**
     * @Route("/company/")
     */
    public function listAction()
    {
        $companies = $this->companyManager->getList();

        return $this->render('AppBundle:Company:list.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/company/{id}")
     */
    public function showAction($id)
    {
        $company = $this->companyManager->getById($id);

        return $this->render('AppBundle:Company:show.html.twig', [
            'company' => $company
        ]);
    }

}
