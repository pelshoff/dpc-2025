<?php
declare(strict_types=1);

namespace Modules\Claims;

use Symfony\Component\Uid\Ulid;

interface ClaimsRepository
{
    public function save(Claim $claim): void;

    public function get(Ulid $id): Claim;
}
