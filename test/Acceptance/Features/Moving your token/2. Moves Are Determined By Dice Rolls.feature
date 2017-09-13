Feature:
  As a player
  I want to move my token based on the roll of a die
  So that there is an element of chance in the game

  Background:
    Given the game is started
    And the token is placed on the board

  Scenario:
    When the player rolls a die
    Then the result should be between 1-6 inclusive

  Scenario:
    Given the player rolls a 4
    When they move their token
    Then the token should move 4 spaces
