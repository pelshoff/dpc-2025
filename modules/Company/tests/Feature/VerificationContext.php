<?php
declare(strict_types=1);

namespace Modules\Company\Tests\Feature;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final readonly class VerificationContext implements Context
{

    /**
     * @Given /^that I have a test$/
     */
    public function thatIHaveATest()
    {
        throw new PendingException();
    }

    /**
     * @When /^I execute the test$/
     */
    public function iExecuteTheTest()
    {
        throw new PendingException();
    }

    /**
     * @Then /^it passes\?$/
     */
    public function itPasses()
    {
        throw new PendingException();
    }
}
