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
