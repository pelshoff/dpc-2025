<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Unit;

use Modules\Company\CompaniesHouseClient;
use Modules\Company\Company;
use Modules\Company\CompanyType;
use Modules\Company\VerificationService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VerificationServiceTest extends TestCase
{
    #[Test]
    public function always_verifies_sole_traders(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new Company('Dummy ST', 'Dummy ST', CompanyType::SoleTrader, null);

        $client->expects($this->never())->method('getCompanyProfile');

        new VerificationService($client)->verifyCompany($company);
    }

    #[Test]
    public function verifies_llcs_through_the_companies_house(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new Company('Dummy Llc.', 'Dummy Llc.', CompanyType::LimitedLiabilityCompany, 'abc123');

        $client->expects($this->once())->method('getCompanyProfile');

        new VerificationService($client)->verifyCompany($company);
    }

    #[Test]
    public function verifies_llps_through_the_companies_house(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new Company('Dummy Llp.', 'Dummy Llp.', CompanyType::LimitedLiabilityPartnership, 'abc123');

        $client->expects($this->once())->method('getCompanyProfile');

        new VerificationService($client)->verifyCompany($company);
    }
}
