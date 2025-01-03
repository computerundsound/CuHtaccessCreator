<?php

namespace App\Command;

use App\Service\CuHtaccessCreator\CuHtaccessCreator;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name       : 'cu:pw-protect',
    description: 'Creates all necessary .htaccess files.',
)]
class CuPwProtectCommand extends Command
{

    private const PATHS_FROM_ROOT = [
        '../pw.txt' => '../secure/.htpwd'
    ];
    private CuHtaccessCreator $htaccessCreator;

    public function __construct(CuHtaccessCreator $cuHtaccessCreator)
    {
        $this->htaccessCreator   = $cuHtaccessCreator;

        parent::__construct();


    }

    protected function configure(): void
    {

        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        foreach (self::PATHS_FROM_ROOT as $srcPath => $destPath) {


            $root = $this->getApplication()->getKernel()->getProjectDir() . DIRECTORY_SEPARATOR;

            $srcPath  = new SplFileInfo($root . $srcPath);
            $destPath = new SplFileInfo($root . $destPath);

            $this->htaccessCreator->createHtaccess($io, $srcPath, $destPath);

        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
