<?php
declare(strict_types=1);

namespace Modules\Company;

enum CompanyType
{
    case SoleTrader;
    case LimitedLiabilityCompany;
    case LimitedLiabilityPartnership;
}
