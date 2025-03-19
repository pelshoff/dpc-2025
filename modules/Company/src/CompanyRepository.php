<?php
declare(strict_types=1);

namespace Modules\Company;

use Symfony\Component\Uid\Ulid;

interface CompanyRepository
{
    public function save(\Modules\Company\Company $param);

    public function get(Ulid $id);
}
