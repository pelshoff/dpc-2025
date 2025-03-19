<?php
declare(strict_types=1);

namespace Modules\Company;

use Modules\Company\Company\InReviewCompany;
use Modules\Company\Company\RejectedCompany;
use Modules\Company\Company\VerifiedCompany;
use Symfony\Component\Uid\Ulid;

final readonly class VerificationService
{
    public function __construct(private CompanyRepository $repository, private CompaniesHouseClient $companiesHouseClient)
    {

    }

    public function verifyCompany(Ulid $id): void
    {
        $company = $this->repository->get($id);
        $newCompany = $company->verify(new CompanyValidator($this->companiesHouseClient));
        $this->repository->save($newCompany);
    }
}
