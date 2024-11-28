<?php

namespace App\Service\CuHtaccessCreator\app;

use SplFileInfo;

class TextFileReader
{


    public function readTextFile(SplFileInfo $textFilePath): array
    {


        $lines = file($textFilePath->getPathname());

        $users = [];

        foreach ($lines as $line) {

            $user = $this->creatUserFromLine($line);

            $users[$user->getUserName()] = $user;
        }

        return $users;

    }

    protected function creatUserFromLine(string $line): UserInfo
    {

        $elements = explode(':', $line);

        $username          = $elements[0];
        $password          = $elements[1];
        $passwordEncrypted = $password;
        $remark            = $elements[2] ?? '';

        return new UserInfo($username, $password, $passwordEncrypted, $remark);


    }

}