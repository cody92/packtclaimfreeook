<?php

namespace ClaimPacktFree\Tests\Bootstrap;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var string
     */
    private $packtFreeLearningUrl;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($packtFreeLearningUrl, $username, $password)
    {
        $this->packtFreeLearningUrl = $packtFreeLearningUrl;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Opens homepage.
     *
     * @Given /^I click on login button$/
     */
    public function iClickOnLoginButton()
    {
        $session = $this->getSession();
        $session->wait(10000, '$("#menuIcon").length');

        $locator = 'menuIcon';
        $loginButton = $session->getPage()->findById($locator);
        if (!$loginButton) {
            throw new ElementNotFoundException($this->getSession()->getDriver(), 'link', 'id', $locator);
        }

        $loginButton->click();

        $session->wait(10000, "$('.respoPage').attr('state') == 'show'");

        $selector = 'css';
        $linkLoginLocator = '.respoLogin';
        $loginLinkSelector = $session->getPage()->find($selector, $linkLoginLocator);

        if (!$loginLinkSelector) {
            throw new ElementNotFoundException($this->getSession()->getDriver(), 'link', $selector, $linkLoginLocator);
        }

        $loginLinkSelector->click();
    }

    /**
     * Fill email field
     *
     * @Given /^I complete email field$/
     */
    public function iCompleteEmailField()
    {
        $this->fillField('email', (string)$this->username);
    }

    /**
     * Fill password field
     *
     * @Given /^I complete password field$/
     */
    public function iCompletePasswordField()
    {
        $this->fillField('password', (string)$this->password);
    }

    /**
     * Fill email field
     *
     * @Given /^I submit login form$/
     */
    public function iSubmitLoginForm()
    {
        $formId = 'packt-user-login-form-respo';
        $form = $this->getSession()->getPage()->findById($formId);
        if (!$form) {
            throw new ElementNotFoundException($this->getSession()->getDriver(), 'form', 'id', $formId);
        }
        $form->submit();
    }

    /**
     * Pauses the scenario until the user presses a key. Useful when debugging a scenario.
     *
     * @Then (I )put a breakpoint
     */
    public function iPutABreakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {
        }
        fwrite(STDOUT, "\033[u");

        return;
    }

    /**
     * @Given /^I go to free learning books section$/
     */
    public function iGoToFreeLearningBooksSection()
    {
        $this->visit($this->packtFreeLearningUrl);
    }

    /**
     * @Given /^I claim free book$/
     */
    public function iClaimFreeBook()
    {
        $selector = 'css';
        $locator = '.twelve-days-claim';
        $linkToClaim = $this->getSession()->getPage()->find($selector, $locator);
        if (!$linkToClaim) {
            throw new ElementNotFoundException($this->getSession()->getDriver(), 'link', 'css', $locator);
        }
        $linkToClaim->click();
    }

    /**
     * @Given /^I download today book$/
     */
    public function iDownloadTodayBook()
    {
        $this->visit('/ebook_download/12544/pdf');
    }
}
