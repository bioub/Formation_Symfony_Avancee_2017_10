<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 06/10/2017
 * Time: 09:57
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

class CompanyManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CompanyManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function getRepository() {
        return $this->em->getRepository(Company::class);
    }

    /**
     * @return Company[]
     */
    public function getList() {
        return $this->getRepository()->findAll();
    }

    public function getById($id) {
        return $this->getRepository()->find($id);
    }
}
