<?php
declare(strict_types=1);

namespace Modules\Company\Infra;

use App\Models\Company;
use Modules\Company\Company\InReviewCompany;
use Modules\Company\Company\RejectedCompany;
use Modules\Company\Company\UnverifiedCompany;
use Modules\Company\Company\VerifiedCompany;
use Modules\Company\CompanyRepository;
use Modules\Company\CompanyType;
use Modules\Company\CompanyType\Llc;
use Modules\Company\CompanyType\Llp;
use Modules\Company\CompanyType\SoleTrader;
use Symfony\Component\Uid\Ulid;

final readonly class DbCompanyRepository implements CompanyRepository
{
    const array VerificationStatusMap = [
        UnverifiedCompany::class => 'unverified',
        VerifiedCompany::class => 'verified',
        RejectedCompany::class => 'rejected',
        InReviewCompany::class => 'in-review',
    ];

    public function __construct()
    {
    }

    public function save(\Modules\Company\Company $param)
    {
        $company = new Company(array_merge(
            [
                'ulid' => $param->id,
                'name' => $param->name,
                'trading_name' => $param->tradingName,
                'verification_status' => $this->verificationStatusFrom($param),
                'officers' => $param->officers,
            ],
            $this->databaseDataFromType($param->type),
        ));
        $company->save();
    }

    public function get(Ulid $id)
    {
        $company = Company::find($id);
        $class = array_flip(self::VerificationStatusMap)[$company->verification_status];
        return new $class(
            $id,
            $company->name,
            $company->trading_name,
            $this->typeFromDatabaseData($company),
            array_map(fn (array $officer) => new Officer($officer['name']), $company->officers),
        );
    }

    /**
     * @param \Modules\Company\Company $param
     * @return string
     */
    public function verificationStatusFrom(\Modules\Company\Company $param): string
    {
        return self::VerificationStatusMap[$param::class];
    }

    public function databaseDataFromType(CompanyType $type): array
    {
        if ($type instanceof SoleTrader) {
            return [
                'type' => 'sole_trader',
                'registration_number' => null,
            ];
        }
        if ($type instanceof Llc) {
            return [
                'type' => 'llc',
                'registration_number' => $type->registrationNumber,
            ];
        }
        if ($type instanceof Llp) {
            return [
                'type' => 'llp',
                'registration_number' => $type->registrationNumber,
            ];
        }
    }

    private function typeFromDatabaseData($company): CompanyType
    {
        if ($company->type === 'sole_trader') {
            return new SoleTrader();
        }
        if ($company->type === 'llc') {
            return new Llc($company->registration_number);
        }
        if ($company->type === 'llp') {
            return new Llp($company->registration_number);
        }
    }
}
