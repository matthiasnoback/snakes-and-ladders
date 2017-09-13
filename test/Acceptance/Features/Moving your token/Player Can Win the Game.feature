Feature:
  As a player
  I want to be able to win the game
  So that I can gloat to everyone around

  Background:
    Given the game is started
    And the token is placed on the board

  Scenario:
    Given the token has arrived on square 97
    When the token is moved 3 spaces
    Then the token is on square 100
    And the player has won the game

  Scenario:
    Given the token has arrived on square 97
    When the token is moved 4 spaces
    Then the token is on square 97
    And the player has not won the game
