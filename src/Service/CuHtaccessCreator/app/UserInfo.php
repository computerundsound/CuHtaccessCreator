<?php

namespace App\Service\CuHtaccessCreator\app;

class UserInfo
{

    protected string $userName = '';
    protected string $pwText = '';
    protected ?string $pwEncrypted;
    protected ?string $remark = '';

    public function __construct(string $userName, string $pwText, string $remark = null)
    {
        $this->userName = $userName;
        $this->pwText   = $pwText;
        $this->remark   = $remark;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPwText(): string
    {
        return $this->pwText;
    }

    public function getPwEncrypted(): ?string
    {
        return $this->pwEncrypted;
    }

    public function setPwEncrypted(string $pwEncrypted): void
    {
        $this->pwEncrypted = $pwEncrypted;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function toArray(): array
    {
        return [
            'userName'    => $this->userName,
            'pwText'      => $this->pwText,
            'pwEncrypted' => $this->pwEncrypted,
            'remark'      => $this->remark
        ];
    }

}