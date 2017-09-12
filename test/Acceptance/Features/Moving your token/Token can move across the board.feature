Feature:
  As a player
  I want to be able to move my token
  So that I can get closer to the goal

  Scenario:
    Given the game is started
    When the token is placed on the board
    Then the token is on square 1

  Scenario:
    Given the game is started
    And the token is placed on the board
    When the token is moved 3 spaces
    Then the token is on square 4

  Scenario:
    Given the game is started
    And the token is placed on the board
    When the token is moved 3 spaces
    And then it is moved 4 spaces
    Then the token is on square 8
