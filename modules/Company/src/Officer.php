<?php
declare(strict_types=1);

namespace Modules\Company;

final readonly class Officer
{
    public function __construct(public string $name)
    {
    }

    public function isSameAs(array $officer): bool
    {
        return $this->name === $officer['name'];
    }

    public function isOnTheListOf(array $officers)
    {
        foreach ($officers as $officer) {
            if ($this->isSameAs($officer)) {
                return true;
            }
        }
        return false;
    }
}
