<?php
declare(strict_types=1);

namespace Modules\Claims\Claim;

use Modules\Claims\Claim;
use Money\Money;
use Symfony\Component\Uid\Ulid;

final readonly class InitialClaim implements Claim
{
    public function __construct(public Ulid $id, public string $description)
    {

    }

    public function estimate(Money $estimate): EstimatedClaim
    {
        return new EstimatedClaim(
            $this->id,
            $this->description,
            $estimate,
            $estimate->subtract($estimate)
        );
    }

    public function reject(): RejectedClaim
    {
        return new RejectedClaim($this->id, $this->description);
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
