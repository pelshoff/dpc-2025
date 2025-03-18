<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Unit;

use Modules\Company\CompaniesHouseClient;
use Modules\Company\Company\InReviewCompany;
use Modules\Company\Company\RejectedCompany;
use Modules\Company\Company\UnverifiedCompany;
use Modules\Company\Company\VerifiedCompany;
use Modules\Company\CompanyType\Llc;
use Modules\Company\CompanyType\Llp;
use Modules\Company\CompanyType\SoleTrader;
use Modules\Company\Officer;
use Modules\Company\VerificationService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VerificationServiceTest extends TestCase
{
    #[Test]
    public function always_verifies_sole_traders(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new UnverifiedCompany('Dummy ST', 'Dummy ST', new SoleTrader(), [new Officer('William of Orange')]);

        $actualCompany = new VerificationService($client)->verifyCompany($company);

        $expectedCompany = new VerifiedCompany('Dummy ST', 'Dummy ST', new SoleTrader());
        $this->assertEquals($expectedCompany, $actualCompany);
    }

    #[Test]
    public function verifies_llcs_through_the_companies_house(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new UnverifiedCompany('Dummy Llc.', 'Dummy Llc.', new Llc('abc123'), [new Officer('William of Orange')]);

        $client->expects($this->any())->method('getCompanyProfile')->willReturn('Profile');
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'William of Orange',
            ]
        ]);

        $actualCompany = new VerificationService($client)->verifyCompany($company);

        $expectedCompany = new VerifiedCompany('Dummy Llc.', 'Dummy Llc.', new Llc('abc123'));
        $this->assertEquals($expectedCompany, $actualCompany);
    }

    #[Test]
    public function verifies_llps_through_the_companies_house(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new UnverifiedCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'), [new Officer('William of Orange')]);

        $client->expects($this->any())->method('getCompanyProfile')->willReturn('Profile');
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'William of Orange',
            ]
        ]);

        $actualCompany = new VerificationService($client)->verifyCompany($company);

        $expectedCompany = new VerifiedCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'));
        $this->assertEquals($expectedCompany, $actualCompany);
    }

    #[Test]
    public function rejects_the_company_if_the_companies_house_returns_nothing(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new UnverifiedCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'), [new Officer('William of Orange')]);

        $client->expects($this->any())->method('getCompanyProfile')->willReturn(null);
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'William of Orange',
            ]
        ]);

        $actualCompany = new VerificationService($client)->verifyCompany($company);

        $expectedCompany = new RejectedCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'));
        $this->assertEquals($expectedCompany, $actualCompany);
    }

    #[Test]
    public function puts_the_company_in_review_if_officers_count_matches_but_officers_dont_match(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $company = new UnverifiedCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'), [new Officer('William of Orange')]);

        $client->expects($this->any())->method('getCompanyProfile')->willReturn('Profile');
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'Not William of Orange',
            ]
        ]);

        $actualCompany = new VerificationService($client)->verifyCompany($company);

        $expectedCompany = new InReviewCompany('Dummy Llp.', 'Dummy Llp.', new Llp('abc123'), [new Officer('William of Orange')]);
        $this->assertEquals($expectedCompany, $actualCompany);
    }

    /*
     * Missing cases:
     * - Some officers mismatch but not all
     * - Rejected
     * - Could not verify the company
     * - Internet broken
     */
}
