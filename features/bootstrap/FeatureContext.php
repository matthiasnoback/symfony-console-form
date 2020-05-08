<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Matthias\SymfonyConsoleForm\Tests\AppKernel;
use Matthias\SymfonyConsoleForm\Tests\Helper\StringUtil;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;

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
        $this->application->setAutoExit(false);
        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @Given /^I run the command "([^"]*)" and I provide as input$/
     */
    public function iRunTheCommandAndIProvideAsInput($name, TableNode $input)
    {
        $inputs = array_column($input->getHash(), 'Input');
        $this->runCommandWithInteractiveInput($name, $inputs);
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
        Assert::assertEquals(
            StringUtil::trimLines((string) $expectedOutput),
            StringUtil::trimLines($this->getOutput())
        );
    }

    private function runCommandWithInteractiveInput($name, array $inputs)
    {
        $this->tester->setInputs($inputs);
        $this->tester->run(['command' => $name], array('interactive' => true, 'decorated' => false));
    }

    /**
     * @Then /^the output should contain$/
     */
    public function theOutputShouldContain(PyStringNode $expectedOutput)
    {
        Assert::assertStringContainsString(
            StringUtil::trimLines((string) $expectedOutput),
            StringUtil::trimLines($this->getOutput())
        );
    }

    /**
     * @Then /^the output should not contain$/
     */
    public function theOutputShouldNotContain(PyStringNode $expectedOutput)
    {
        Assert::assertStringNotContainsString(
            StringUtil::trimLines($this->getOutput()),
            StringUtil::trimLines((string) $expectedOutput)
        );
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
        if ($this->tester->getStatusCode() !== 0) {
            throw new RuntimeException(
                "Expected the command to succeed. Command output:\n" . $this->getOutput()
            );
        }
    }

    /**
     * @Then /^the command was not successful$/
     */
    public function theCommandWasNotSuccessful()
    {
        Assert::assertNotEquals(0, $this->tester->getStatusCode());
    }

    /**
     * @When /^I run a command non-interactively with parameters$/
     */
    public function iRunTheCommandNonInteractively(TableNode $parameters)
    {
        $parameters = $parameters->getHash();

        $input = array_combine(
            array_column($parameters, 'Parameter'),
            array_column($parameters, 'Value')
        );

        $this->runCommandWithNonInteractiveInput($input);
    }

    private function runCommandWithNonInteractiveInput(array $input)
    {
        $this->tester->run($input, array('interactive' => false, 'decorated' => false));
    }
}
