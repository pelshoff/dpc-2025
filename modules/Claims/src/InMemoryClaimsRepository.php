<?php
declare(strict_types=1);

namespace Modules\Claims;

use Symfony\Component\Uid\Ulid;

final class InMemoryClaimsRepository implements ClaimsRepository
{
    private array $claims = [];

    public function save(Claim $claim): void
    {
        $this->claims[$claim->id->toString()] = $claim;
    }

    public function get(Ulid $id): Claim
    {
        return $this->claims[$id->toString()];
    }


}
