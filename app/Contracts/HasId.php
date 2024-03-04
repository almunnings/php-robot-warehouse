<?php

declare(strict_types=1);

namespace App\Contracts;

interface HasId
{
    public function id(): string;
}
