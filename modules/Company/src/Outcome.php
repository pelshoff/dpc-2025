<?php
declare(strict_types=1);

namespace Modules\Company;

use Symfony\Component\Uid\Ulid;

interface Outcome
{
    public function processFor(Ulid $id, string $name, string $tradingName, CompanyType $type, array $officers): NotUnverifiedCompany;
}
