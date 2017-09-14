Feature:
  As a player
  I want ladders to move my token up
  So that the game is more fun

  Background:
    Given the game is started
    And the token is placed on the board

  Scenario:
    Given there is a ladder connecting squares 2 and 12
    When the token lands on square 2
    Then the token is on square 12

  Scenario:
    Given there is a ladder connecting squares 2 and 12
    When the token lands on square 12
    Then the token is on square 12
