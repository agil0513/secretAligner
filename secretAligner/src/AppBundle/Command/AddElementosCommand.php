<?php
// src/AppBundle/Command/AddElementosCommand.php
namespace AppBundle\Command;

use AppBundle\Entity\Todo;
use DateTime;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddElementosCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:añadir-elemento';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Añadir Nuevo Elemento')
            ->addArgument('Nombre', InputArgument::OPTIONAL, 'Nombre de la tarea')
            ->addArgument('Fecha tope',  InputArgument::OPTIONAL, 'Fecha Tope')
            ->addArgument('Estado',   InputArgument::OPTIONAL, 'Estado')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io = new SymfonyStyle($input, $output);
        $nombre = $input->getArgument('Nombre');
        $fechaTope = strtotime($input->getArgument('Fecha tope'));
        $date = \date("Y-m-d H:i:s", $fechaTope);
        $now = date("Y-m-d H:i:s");
        $estado = $input->getArgument('Estado');

        if ($nombre) {
            $io->note(sprintf('Nombre: %s', $nombre));
        }
        if ($fechaTope) {
            $io->note(sprintf('Fecha Tope: %s', $date));
        }
        if ($estado) {
            $io->note(sprintf('Estado: %s', $estado));
        }

        $entityManager = $this->container->get('doctrine')->getManager();
        $todo = new todo;
        $todo->setNombre($nombre);
        $todo->setFechaTope(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
        $todo->setFechaCreacion(\DateTime::createFromFormat('Y-m-d H:i:s', $now));
        $todo->setEstado((bool)$estado);
        $entityManager->persist($todo);
        $entityManager->flush();


    }
}