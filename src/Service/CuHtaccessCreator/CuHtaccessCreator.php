<?php

namespace App\Service\CuHtaccessCreator;


use App\Service\CuHtaccessCreator\app\TextFileReader;
use App\Service\CuHtaccessCreator\app\UserInfo;
use SplFileInfo;
use Symfony\Component\Console\Style\SymfonyStyle;


class CuHtaccessCreator
{


    protected TextFileReader $textFileReader;

    public function __construct(TextFileReader $textFileReader)
    {
        $this->textFileReader = $textFileReader;
    }

    public function createHtaccess(SymfonyStyle $io, SplFileInfo $srcFile, SplFileInfo $destFile): string
    {

        $io->info(['SrcFile: ' . $srcFile->getRealPath(), 'DestFile: ' . $destFile->getRealPath()]);

        /** @var UserInfo[] $users */
        $users = $this->textFileReader->readTextFile($srcFile);

        $io->newLine();
        $io->writeln('Creating .htpwd file ' . $destFile->getRealPath());
        $io->newLine();

        $htaccessContent = [];

        foreach ($users as $user) {

            $io->write($user->getUserName() . ':' . $user->getPwText());

            $htaccessContent[] = $this->makeLine($user);

        }

        $htaccessContentString = implode(PHP_EOL, $htaccessContent);
        file_put_contents($destFile->getRealPath(), $htaccessContentString);

        return $htaccessContentString;

    }

    protected function makeLine(UserInfo $user): string
    {
        $pwEncrypt = $this->createPWEncrypted($user->getPwText());
        $user->setPwEncrypted($pwEncrypt);

        $line = $user->getUserName() . ':' . $pwEncrypt;

        return $line;
    }

    private function createPWEncrypted(string $pwText): string
    {
        return password_hash($pwText, PASSWORD_BCRYPT);
    }
}

