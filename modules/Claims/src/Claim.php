<?php
declare(strict_types=1);

namespace Modules\Claims;

use Money\Money;

interface Claim
{
    public function balance(): Money;

    public function paidOut(): Money;
}
