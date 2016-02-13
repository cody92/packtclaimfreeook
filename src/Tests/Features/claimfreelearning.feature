Feature: claim packt publishing free learning book

  @javascript
  Scenario: claim packt publishing free learning book for current day
    Given I am on the homepage
    And I click on login button
    And I complete email field
    And I complete password field
    And I submit login form
    And I go to free learning books section
    And I claim free book
    And I download today book
    And I put a breakpoint