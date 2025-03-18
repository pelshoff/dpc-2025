<?php
declare(strict_types=1);

namespace Modules\Company\Company;

use Modules\Company\CompanyType;
use Modules\Company\NotUnverifiedCompany;
use Modules\Company\Officer;

final readonly class InReviewCompany implements NotUnverifiedCompany
{
    public function __construct(
        public string $name,
        public string $tradingName,
        public CompanyType $type,
        /** @var $officers array<int, Officer> */
        public array $officers,
    )
    {
    }
}
