<?php
declare(strict_types=1);

namespace Modules\Claims\Tests\Feature;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Hook\BeforeScenario;
use Modules\Claims\ClaimSubmissionService;
use Modules\Claims\InMemoryClaimsRepository;
use Money\Money;
use PHPUnit\Framework\Assert;
use Symfony\Component\Uid\Ulid;

final readonly class ClaimsContext implements Context
{
    private ClaimSubmissionService $service;
    private Ulid $claimId;

    #[BeforeScenario]
    public function setup(): void
    {
        $this->service = new ClaimSubmissionService(new InMemoryClaimsRepository());
    }

    /**
     * @Given /^a claim was submitted$/
     */
    public function aClaimWasSubmitted()
    {
        $this->service->submit(
            $this->claimId = new Ulid(),
            'My fish hit a car'
        );
    }

    /**
     * @Given the claim was estimated at :amount
     */
    public function andAnInitialEstimate(int $amount)
    {
        $this->service->estimate($this->claimId, Money::EUR($amount));
    }

    /**
     * @When the claim is settled for :amount
     */
    public function theClaimIsSettled(int $amount)
    {
        $this->service->settle($this->claimId, Money::EUR($amount));
    }

    /**
     * @When the claim is rejected
     */
    public function theClaimIsRejected()
    {
        $this->service->reject($this->claimId);
    }

    /**
     * @When the claim is paid out early for :amount
     */
    public function theClaimIsPaidOutEarlyFor(int $amount)
    {
        $this->service->payOut($this->claimId, Money::EUR($amount));
    }

    /**
     * @Then the balance is :amount
     */
    public function iExpectTheBalanceToBe(int $amount)
    {
        Assert::assertEquals($amount, $this->service->balance($this->claimId)->getAmount());
    }

    /**
     * @Given the paid out is :amount
     */
    public function thePaidOutIs(int $amount)
    {
        Assert::assertEquals($amount, $this->service->paidOut($this->claimId)->getAmount());
    }
}
