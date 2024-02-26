<?php

namespace App\Command;

use App\Service\SheetImport;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

#[AsCommand(
    name: 'app:import-sheet',
    description: 'Command to import sheet',
)]
class ImportSheetCommand extends Command
{
    public function __construct(
        private ContainerBagInterface $containerBag,
        private SheetImport $sheetImport,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $sheetFile = $this->containerBag->get('kernel.project_dir') . "/files/import.xlsx";

        $this->sheetImport->import($sheetFile);

        $io->success('Data imported');

        return Command::SUCCESS;
    }
}
