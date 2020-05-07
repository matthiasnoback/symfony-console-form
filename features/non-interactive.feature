Feature: It is possible to interactively fill in a form from the CLI

  Scenario: Provide a value different than the default value
    When I run a command non-interactively with parameters
      | Parameter | Value     |
      | command   | form:name |
      | --name    | Menno     |
    Then the output should contain
      """
      Array
      (
          [name] => Menno
      )
      """

  Scenario: Provide values for a repeated field
    When I run a command non-interactively with parameters
      | Parameter  | Value                  |
      | command    | form:repeated_password |
      | --password | test                   |
    Then the output should contain
      """
      Array
      (
          [password] => test
      )
      """

  Scenario: Options for fields appear in the help text of a command
    When I run a command non-interactively with parameters
      | Parameter | Value                  |
      | command   | form:repeated_password |
      | --help    |                        |
    Then the output should contain
    """
    Options:
     --password
    """

  Scenario: Provide invalid value
    When I run a command non-interactively with parameters
      | Parameter | Value         |
      | command   | form:color    |
      | --color   | invalid color |
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
