Feature:
  As a player
  I want to follow the play order
  So that the game is more fair

  Background:
    Given there are 2 players

  Scenario:
    When Player 1 has moved their token
    Then it is Player 2's turn

  Scenario:
    Given Player 1 has moved their token
    When Player 2 has moved their token
    Then it is Player 1's turn
