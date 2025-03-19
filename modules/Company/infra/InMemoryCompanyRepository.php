<?php
declare(strict_types=1);

namespace Modules\Company\Infra;

use Modules\Company\Company;
use Modules\Company\CompanyRepository;
use Symfony\Component\Uid\Ulid;

final class InMemoryCompanyRepository implements CompanyRepository
{
    private array $companies = [];

    public function save(Company $param)
    {
        $this->companies[$param->id->toString()] = $param;
    }

    public function get(Ulid $id)
    {
        return $this->companies[$id->toString()];
    }
}
