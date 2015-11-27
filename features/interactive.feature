Feature: It is possible to interactively fill in a form from the CLI

  Scenario: Provide a value different than the default value
    When I run the command "form:name" and I provide as input
      """
      Menno[enter]
      """
    Then the output should be
      """
      Your name [Matthias]: Array
      (
          [name] => Menno
      )
      """

  Scenario: Provide no value, the default value will be used
    When I run the command "form:name" and I provide as input "[enter]"
    Then the command has finished successfully
    And the output should be
      """
      Your name [Matthias]: Array
      (
          [name] => Matthias
      )
      """


  Scenario: Provide invalid input, the form errors will be printed
    When I run the command "form:name" and I provide as input
      """
      A[enter]
      """
    Then the command was not successful
    And the output should contain
      """
      This value is too short.
      """

  Scenario: Provide a date as text
    When I run the command "form:date_of_birth" and I provide as input
      """
      2015-03-04[enter]
      """
    Then the command has finished successfully
    And the output should be
      """
      Your date of birth [1879-03-14]: Array
      (
          [dateOfBirth] => DateTime Object
          (
              [date] => 2015-03-04 00:00:00.000000
              [timezone_type] => 2
              [timezone] => GMT
          )
      )
      """

  Scenario: Select a value
    When I run the command "form:color" and I provide as input
      """
      blue[enter]
      """
    Then the command has finished successfully
    And the output should be
      """
      Select color [red]:
        [red   ] Red
        [blue  ] Blue
        [yellow] Yellow
      > Array
      (
          [color] => blue
      )
      """

  @symfony27
  Scenario: Select a value
    When I run the command "form:color_with_choices_as_values" and I provide as input
      """
      Blue[enter]
      """
    Then the command has finished successfully
    And the output should be
    """
      Select color [red]:
        [0] Red (red)
        [1] Blue (blue)
        [2] Yellow (yellow)
      > Array
      (
          [color] => blue
      )
      """

  @symfony27
  Scenario: Select a value by its underlying data
    When I run the command "form:color_with_choices_as_values" and I provide as input
      """
      red[enter]
      """
    Then the command has finished successfully
    And the output should be
    """
      Select color [red]:
        [0] Red (red)
        [1] Blue (blue)
        [2] Yellow (yellow)
      > Array
      (
          [color] => red
      )
      """
