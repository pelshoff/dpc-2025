<?php
declare(strict_types=1);

namespace Modules\Claims;

use Modules\Claims\Claim\InitialClaim;
use Money\Money;
use Symfony\Component\Uid\Ulid;

final readonly class ClaimSubmissionService
{
    public function __construct(private ClaimsRepository $repository)
    {
    }

    public function submit(Ulid $id, string $text)
    {
        $this->repository->save(new InitialClaim($id, $text));
    }

    public function getClaim(Ulid $id): string
    {
        return $this->repository->get($id)->description;
    }

    public function estimate(Ulid $id, Money $estimate): void
    {
        $claim = $this->repository->get($id);
        $this->repository->save($claim->estimate($estimate));
    }

    public function payOut(Ulid $id, Money $payOut)
    {
        $claim = $this->repository->get($id);
        $this->repository->save($claim->payOut($payOut));
    }

    public function settle(Ulid $id, Money $settlement): void
    {
        $claim = $this->repository->get($id);
        $this->repository->save($claim->settle($settlement));
    }

    public function reject(Ulid $id)
    {
        $claim = $this->repository->get($id);
        $this->repository->save($claim->reject());
    }

    public function balance(Ulid $id): Money
    {
        $claim = $this->repository->get($id);
        return $claim->balance();
    }

    public function paidOut(Ulid $id): Money
    {
        $claim = $this->repository->get($id);
        return $claim->paidOut();
    }
}
