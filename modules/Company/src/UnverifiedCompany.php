<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class UnverifiedCompany
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

    public function verify(CompanyValidator $validator)
    {
        if ($this->type->verify($validator, $this->officers)) {
            return new VerifiedCompany($this->name, $this->tradingName, $this->type);
        }
        return new RejectedCompany($this->name, $this->tradingName, $this->type);
    }
}
