<?php

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Matthias\SymfonyConsoleForm\Tests\AppKernel;
use Matthias\SymfonyConsoleForm\Tests\Helper\ApplicationTester;
use Matthias\SymfonyConsoleForm\Tests\Helper\StringUtil;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var ApplicationTester
     */
    private $tester;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        ini_set('date.timezone', 'UTC');

        $kernel = new AppKernel('test', true);
        $this->application = new Application($kernel);
        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @Given /^I run the command "([^"]*)" and I provide as input$/
     */
    public function iRunTheCommandAndIProvideAsInput($name, PyStringNode $input)
    {
        $this->runCommandWithInteractiveInput($name, $input);
    }

    /**
     * @Given /^I run the command "([^"]*)" and I provide as input "([^"]*)"$/
     */
    public function iRunTheCommandAndIProvideAsInputOneLine($name, $input)
    {
        $this->runCommandWithInteractiveInput($name, $input);
    }

    /**
     * @Then /^the output should be$/
     */
    public function theOutputShouldBe(PyStringNode $expectedOutput)
    {
        \PHPUnit_Framework_Assert::assertSame(
            StringUtil::trimLines((string) $expectedOutput),
            StringUtil::trimLines($this->getOutput())
        );
    }

    private function runCommandWithInteractiveInput($name, $input)
    {
        $input = str_replace('[enter]', "\n", $input);
        $this->tester->putToInputStream($input);
        $this->tester->run($name, array('interactive' => true, 'decorated' => false));
    }

    /**
     * @Then /^the output should contain$/
     */
    public function theOutputShouldContain(PyStringNode $expectedOutput)
    {
        Assertion::contains(StringUtil::trimLines($this->getOutput()), StringUtil::trimLines((string) $expectedOutput));
    }

    /**
     * @Then /^the output should not contain$/
     */
    public function theOutputShouldNotContain(PyStringNode $expectedOutput)
    {
        Assertion::false(strpos(StringUtil::trimLines($this->getOutput()), StringUtil::trimLines((string) $expectedOutput)));
    }

    private function getOutput()
    {
        return $this->tester->getDisplay(true);
    }

    /**
     * @Then /^the command has finished successfully$/
     */
    public function theCommandHasFinishedSuccessfully()
    {
        Assertion::same($this->tester->getStatusCode(), 0);
    }

    /**
     * @Then /^the command was not successful$/
     */
    public function theCommandWasNotSuccessful()
    {
        Assertion::notSame($this->tester->getStatusCode(), 0);
    }

    /**
     * @When /^I run the command "([^"]*)" non\-interactively$/
     */
    public function iRunTheCommandNonInteractively($command)
    {
        $this->runCommandWithNonInteractiveInput($command);
    }

    private function runCommandWithNonInteractiveInput($name)
    {
        $this->tester->run($name, array('interactive' => false, 'decorated' => false));
    }
}
