<?php
declare(strict_types=1);

namespace Modules\Claims\Claim;

use Modules\Claims\Claim;
use Money\Money;
use Symfony\Component\Uid\Ulid;

final readonly class EstimatedClaim implements Claim
{
    public function __construct(
        public Ulid $id,
        public string $description,
        public Money $estimate,
        public Money $paidOut
    )
    {
    }

    public function balance(): Money
    {
        return $this->estimate;
    }

    public function paidOut(): Money
    {
        return $this->paidOut;
    }

    public function payOut(Money $payOut): EstimatedClaim
    {
        if ($payOut->greaterThan($this->estimate)) {
            throw new \LogicException('Cannot pay out more than reserved');
        }
        return new EstimatedClaim(
            $this->id,
            $this->description,
            $this->estimate->subtract($payOut),
            $this->paidOut->add($payOut)
        );
    }

    public function settle(Money $settlement): SettledClaim
    {
        return new SettledClaim($this->id, $this->description, $settlement);
    }
}
