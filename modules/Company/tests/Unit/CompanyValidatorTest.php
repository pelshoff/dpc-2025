<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Unit;

use Modules\Company\CompaniesHouseClient;
use Modules\Company\CompanyValidator;
use Modules\Company\Officer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CompanyValidatorTest extends TestCase
{
    #[Test]
    public function reject_if_not_all_officers_match(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $client->expects($this->any())->method('getCompanyProfile')->willReturn('Profile');
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'William of Orange',
            ]
        ]);
        $officers = [new Officer('William of Orange'), new Officer('Not William of Orange')];
        $this->assertFalse(new CompanyValidator($client)->verify('abc123', $officers));
    }

    #[Test]
    public function manual_review_if_an_officer_almost_matches(): void
    {
        $client = $this->getMockBuilder(CompaniesHouseClient::class)->getMock();
        $client->expects($this->any())->method('getCompanyProfile')->willReturn('Profile');
        $client->expects($this->any())->method('listOfficers')->willReturn([
            [
                'name' => 'William of Orange',
            ],
            [
                'name' => 'William of Green',
            ]
        ]);
        $officers = [new Officer('William of Orange'), new Officer('William of Gren')];
        $this->assertEquals("maybe", new CompanyValidator($client)->verify('abc123', $officers));
    }
}
