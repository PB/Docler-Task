<?php

declare(strict_types=1);

namespace App\Domain\Query;

interface Query
{
    /**
     * @return mixed
     */
    public function execute(): mixed;
}
