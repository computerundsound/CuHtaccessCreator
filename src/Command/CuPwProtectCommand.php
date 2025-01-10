<?php

namespace App\Command;

use App\Service\CuHtaccessCreator\CuHtaccessCreator;
use Exception;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name       : 'cu:pw-protect',
    description: 'Creates all necessary .htaccess files.',
)]
class CuPwProtectCommand extends Command
{

    private CuHtaccessCreator $htaccessCreator;
    private array $pathsForSourceAndDestFromProjectRoot;

    public function __construct(CuHtaccessCreator $cuHtaccessCreator, array $pathsForSourceAndDestFromProjectRoot)
    {
        $this->htaccessCreator = $cuHtaccessCreator;

        parent::__construct();


        $this->pathsForSourceAndDestFromProjectRoot = $pathsForSourceAndDestFromProjectRoot;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->pathsForSourceAndDestFromProjectRoot as $paths) {

            if (false === key_exists('destFile', $paths) || false === key_exists('sourceFile', $paths)) {
                throw new Exception('Pathconfiguration in user-config.yaml is wrong');
            }

            $root = $this->getApplication()->getKernel()->getProjectDir() . DIRECTORY_SEPARATOR;

            $srcPath  = new SplFileInfo($root . $paths['sourceFile']);
            $destPath = new SplFileInfo($root . $paths['destFile']);

            $this->htaccessCreator->createHtaccess($io, $srcPath, $destPath);

        }

        $io->success('Passwords inserted successfully.');

        return Command::SUCCESS;
    }
}
