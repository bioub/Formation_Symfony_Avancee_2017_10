<?php

namespace AppBundle\Controller\Rest;


use AppBundle\Manager\CompanyManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/companies")
 */
class CompanyRestController extends Controller
{
    /**
     * @var CompanyManager
     */
    protected $companyManager;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * CompanyRestController constructor.
     * @param CompanyManager $companyManager
     * @param Serializer $serializer
     */
    public function __construct(CompanyManager $companyManager, Serializer $serializer)
    {
        $this->companyManager = $companyManager;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/{_format}", methods={"GET"}, defaults={"_format": "json"})
     */
    public function listAction($_format)
    {
        $companies = $this->companyManager->getList();
        $json = $this->serializer->serialize($companies, $_format);

        return new Response($json);
    }

    /**
     * @Route("/{_format}/{id}", methods={"GET"})
     */
    public function showAction()
    {

    }
}
