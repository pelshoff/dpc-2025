<?php
declare(strict_types=1);

namespace Modules\Claims\Claim;

use Modules\Claims\Claim;
use Money\Money;
use Symfony\Component\Uid\Ulid;

final readonly class SettledClaim implements Claim
{
    public function __construct(
        public Ulid $id,
        public string $description,
        public Money $paidOut,
    )
    {

    }

    public function balance(): Money
    {
        return $this->paidOut->subtract($this->paidOut);
    }

    public function paidOut(): Money
    {
        return $this->paidOut;
    }
}
