<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Unit;

use Modules\Company\Company;
use Modules\Company\CompanyType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VerificationServiceTest extends TestCase
{
    #[Test]
    public function it_doth_run(): void
    {
        $this->assertInstanceOf(Company::class, new Company('Superscript', 'Superscript B.V.', CompanyType::LimitedLiabilityCompany, 'abc123'));
    }
}
