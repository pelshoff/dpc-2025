<?php
declare(strict_types=1);

namespace Modules\Claims\Claim;

use Modules\Claims\Claim;
use Money\Money;
use Symfony\Component\Uid\Ulid;

final readonly class RejectedClaim implements Claim
{
    public function __construct(public Ulid $id, public string $description)
    {

    }

    public function balance(): Money
    {
        return Money::EUR(0);
    }

    public function paidOut(): Money
    {
        return Money::EUR(0);
    }
}
