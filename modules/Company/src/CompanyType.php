<?php
declare(strict_types=1);

namespace Modules\Company;

interface CompanyType
{
    public function verify(CompanyValidator $validator, array $officers);
}
