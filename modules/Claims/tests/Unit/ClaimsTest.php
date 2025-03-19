<?php
declare(strict_types=1);

namespace Modules\Claims\Tests\Unit;

use Modules\Claims\ClaimSubmissionService;
use Modules\Claims\InMemoryClaimsRepository;
use Money\Money;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Uid\Ulid;
use Tests\TestCase;

final class ClaimsTest extends TestCase
{
    #[Test]
    public function can_be_submitted(): void
    {
        $service = new ClaimSubmissionService(new InMemoryClaimsRepository());

        $service->submit($id = new Ulid(), 'My car hit a fish');

        $this->assertEquals('My car hit a fish', $service->getClaim($id));
    }

    #[Test]
    public function can_receive_an_initial_estimate(): void
    {
        $service = new ClaimSubmissionService(new InMemoryClaimsRepository());
        $service->submit($id = new Ulid(), 'My car hit a fish');

        $service->estimate($id, Money::EUR(1000));

        $this->assertEquals(Money::EUR(1000), $service->balance($id));
    }

    #[Test]
    public function can_be_settled(): void
    {
        $service = new ClaimSubmissionService(new InMemoryClaimsRepository());
        $service->submit($id = new Ulid(), 'My car hit a fish');
        $service->estimate($id, Money::EUR(1000));

        $service->settle($id, Money::EUR(333));

        $this->assertEquals(Money::EUR(0), $service->balance($id));
        $this->assertEquals(Money::EUR(333), $service->paidOut($id));
    }
}
