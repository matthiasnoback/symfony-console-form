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
      ERROR:
    """
    And the output should contain
    """
    There were form errors.
    """

  Scenario: Choice with object options in non-interactive mode
    When I run a command non-interactively with parameters
      | Parameter   | Value                                 |
      | command     | form:unstringable_choices_with_values |
      | --address   | 1600-pennsylvania-ave-nw              |
    Then the command has finished successfully
    And the output should contain
      """
      Array
      (
        [address] => Matthias\SymfonyConsoleForm\Tests\Form\Data\Address Object
          (
            [street] => 1600 Pennsylvania Ave NW
          )
      )
      """

  Scenario: Non-compound form type in non-interactive mode
    When I run a command non-interactively with parameters
      | Parameter   | Value                   |
      | command     | form:non_compound_color |
      | --color     | blue                    |
    Then the command has finished successfully
    And the output should contain
      """
      Array
      (
          [0] => blue
      )
      """

  Scenario: A form field is optional and no option has been provided for it

    The default form data for this command (EditUserCommand) has name Mario, lastName Rossi. When running the command,
    only --lastName is provided. Instead of setting name to null, the existing name should not be modified.

    When I run a command non-interactively with parameters
      | Parameter  | Value          |
      | command    | form:edit_user |
      | --lastName | Verdi          |
    Then the command has finished successfully
    And the output should contain
      """
      name: Mario, lastName: Verdi
      """

  Scenario: Nested form type in non-interactive mode
    When I run a command non-interactively with parameters
      | Parameter               | Value                    |
      | command                 | form:nested              |
      | --user[name]            | mario                    |
      | --user[lastname]        | rossi                    |
      | --user[password]        | test                     |
      | --anotherUser[name]     | luigi                    |
      | --anotherUser[lastname] | verdi                    |
      | --anotherUser[password] | test2                    |
      | --color                 | blue                     |
    Then the command has finished successfully
    And the output should contain
      """
      Array
      (
          [user] => Array
          (
              [name] => mario
              [lastname] => rossi
              [password] => test
          )
          [anotherUser] => Array
          (
              [name] => luigi
              [lastname] => verdi
              [password] => test2
          )
          [color] => blue
      )
      """
