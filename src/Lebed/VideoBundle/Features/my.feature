Feature: My first feature
  In order to start using Behat
  As a manager or developer
  I need to try

  @javascript
  Scenario: Successfully describing scenario
    Given I am on "/category/20"
    Then I should see "Барбоскины"