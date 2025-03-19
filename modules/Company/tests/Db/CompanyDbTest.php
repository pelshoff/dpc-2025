<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Db;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Modules\Company\Company\InReviewCompany;
use Modules\Company\Company\RejectedCompany;
use Modules\Company\Company\UnverifiedCompany;
use Modules\Company\Company\VerifiedCompany;
use Modules\Company\Infra\DbCompanyRepository;
use Modules\Company\CompanyRepository;
use Modules\Company\CompanyType\Llc;
use Modules\Company\CompanyType\Llp;
use Modules\Company\CompanyType\SoleTrader;
use Modules\Company\Officer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Uid\Ulid;
use Tests\TestCase;

final class CompanyDbTest extends TestCase
{
    use RefreshDatabase;

    public static function companies()
    {
        yield [new UnverifiedCompany(new Ulid(), 'A', 'A', new SoleTrader(), [new Officer('Test Name')])];
        yield [new VerifiedCompany(new Ulid(), 'A', 'A', new SoleTrader(), [new Officer('Test Name')])];
        yield [new RejectedCompany(new Ulid(), 'A', 'A', new SoleTrader(), [new Officer('Test Name')])];
        yield [new InReviewCompany(new Ulid(), 'A', 'A', new SoleTrader(), [new Officer('Test Name')])];
    }

    #[Test]
    #[DataProvider('companies')]
    public function retrieves_saved_unverified_companies($company): void
    {
        /** @var CompanyRepository $service */
        $service = app(DbCompanyRepository::class);
        $service->save($company);

        /** @var CompanyRepository $otherService */
        $otherService = app(DbCompanyRepository::class);
        $actual = $otherService->get($company->id);

        $this->assertEquals($company, $actual);
    }

    #[Test]
    public function retrieves_saved_llcs(): void
    {
        /** @var CompanyRepository $service */
        $service = app(DbCompanyRepository::class);
        $service->save($company = new UnverifiedCompany(new Ulid(), 'A', 'A', new Llc('abc123'), [new Officer('Test Name')]));

        /** @var CompanyRepository $otherService */
        $otherService = app(DbCompanyRepository::class);
        $actual = $otherService->get($company->id);

        $this->assertEquals($company, $actual);
    }

    #[Test]
    public function retrieves_saved_llps(): void
    {
        /** @var CompanyRepository $service */
        $service = app(DbCompanyRepository::class);
        $service->save($company = new UnverifiedCompany(new Ulid(), 'A', 'A', new Llp('abc123'), [new Officer('Test Name')]));

        /** @var CompanyRepository $otherService */
        $otherService = app(DbCompanyRepository::class);
        $actual = $otherService->get($company->id);

        $this->assertEquals($company, $actual);
    }

    /*
     * - Not found
     * - Llc
     * - Llp
     */
}
