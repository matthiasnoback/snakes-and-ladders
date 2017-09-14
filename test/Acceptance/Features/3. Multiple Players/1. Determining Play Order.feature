Feature:
  As a player
  I want to influence the play order
  So that player 1 doesn't always go first

  Scenario:
    Given 2 players are rolling to determine play order
    When Player 1 rolls higher than Player 2
    Then Player 1 rolls first

  Scenario:
    Given 2 players are rolling to determine play order
    When Player 2 rolls higher than Player 1
    Then Player 2 rolls first

  Scenario:
    Given 2 players are rolling to determine play order
    When Player 1 rolls the same as Player 2
    Then the players must roll again
