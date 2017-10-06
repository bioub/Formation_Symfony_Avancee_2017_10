<?php

namespace Bioub\AliceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Kernel;

class AliceLoadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('alice:load')
            ->setDescription('...')
            ->addArgument('fixturePath', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('locale', 'l', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixturePath = $input->getArgument('fixturePath');

        if (!$fixturePath) {
            $kernel = $this->getContainer()->get('kernel');
            $projectDir = $kernel->getProjectDir(); // SF 3.3
            $fixturePath = $projectDir . '/fixtures.yml';
        }

        $loader = $this->getContainer()->get('nelmio_alice.file_loader.simple');

        $entities = $loader->loadFile($fixturePath);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        foreach ($entities->getObjects() as $entity) {
            $em->persist($entity);
        }

        $em->flush();

        $output->writeln(count($entities->getObjects()) . ' entities inserted.');
    }

}
