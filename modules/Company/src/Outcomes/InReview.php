<?php
declare(strict_types=1);

namespace Modules\Company\Outcomes;

use Modules\Company\Company\InReviewCompany;
use Modules\Company\CompanyType;
use Modules\Company\NotUnverifiedCompany;
use Modules\Company\Outcome;
use Symfony\Component\Uid\Ulid;

final readonly class InReview implements Outcome
{
    public function processFor(Ulid $id, string $name, string $tradingName, CompanyType $type, array $officers): NotUnverifiedCompany
    {
        return new InReviewCompany($id, $name, $tradingName, $type, $officers);
    }
}
