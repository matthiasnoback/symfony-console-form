Feature: It is possible to interactively fill in a form from the CLI

  Scenario: Provide a value different than the default value
    When I run the command "form:name --name=Menno" non-interactively
    Then the output should be
      """
      Array
      (
          [name] => Menno
      )
      """


  Scenario: Provide values for a repeated field
    When I run the command "form:repeated_password --password=test" non-interactively
    Then the output should be
      """
      Array
      (
          [password] => test
      )
      """

  Scenario: Options for fields appear in the help text of a command
    When I run the command "form:repeated_password --help" non-interactively
    Then the output should contain
    """
    Options:
     --password
    """

  Scenario: Provide invalid value
    When I run the command "form:color --color='invalid color'" non-interactively
    Then the command was not successful
    And the output should contain
    """
    Invalid data provided: color:
      ERROR: This value is not valid.
    """
    And the output should contain
    """
    There were form errors.
    """
