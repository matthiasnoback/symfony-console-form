Feature: It is possible to interactively fill in a form from the CLI

  Scenario: Provide a value different than the default value
    When I run the command "form:name" and I provide as input
      | Input |
      | Menno |
    Then the output should be
      """
      Your name [Matthias]: Array
      (
          [name] => Menno
      )
      """

  Scenario: Provide no value, the default value will be used
    When I run the command "form:name" and I provide as input
      | Input |
      |       |
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
      | Input |
      | A     |
      | Alex  |
    Then the output should contain
      """
      ERROR: This value is too short. It should have 4 characters or more.
      """

  Scenario: Provide a date as text
    When I run the command "form:date_of_birth" and I provide as input
      | Input      |
      | 2015-03-04 |
    Then the command has finished successfully
    And the output should be
      """
      Your date of birth [1987-03-14]: Array
      (
          [dateOfBirth] => 2015-03-04T00:00:00+0000
      )
      """

  Scenario: Provide an integer
    When I run the command "form:age" and I provide as input
      | Input |
      | 10    |
    Then the command has finished successfully
    And the output should be
      """
      Your age: Array
      (
          [age] => 10
      )
      """

  Scenario: Select a value
    When I run the command "form:color" and I provide as input
      | Input |
      | blue  |
    Then the command has finished successfully
    And the output should contain
      """
      Select color [red]:
        [red   ] Red
        [blue  ] Blue
        [yellow] Yellow
      >
      """
    And the output should contain
      """
      Array
      (
          [color] => blue
      )
      """

  Scenario: Select multiple values
    When I run the command "form:multi_select" and I provide as input
      | Input |
      | 1,3   |
    Then the command has finished successfully
    And the output should contain
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      >
      """
    And the output should contain
      """
      Array
      (
        [choices] => Array
          (
            [0] => 1
            [1] => 3
          )
      )
      """

  Scenario: Select one value when multiple values are allowed
    When I run the command "form:multi_select" and I provide as input
      | Input |
      | 2     |
    Then the command has finished successfully
    And the output should contain
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      >
      """
    And the output should contain
      """
      Array
      (
        [choices] => Array
          (
            [1] => 2
          )
      )
      """

  Scenario: Select multiple values with multiple default values
    When I run the command "form:multi_select" and I provide as input
      | Input |
      |       |
    Then the command has finished successfully
    And the output should contain
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      >
      """
    And the output should contain
      """
      Array
      (
        [choices] => Array
          (
            [0] => 1
            [1] => 2
          )
      )
      """

  Scenario: Empty label
    When I run the command "form:empty_label" and I provide as input
      | Input |
      | empty |
    Then the command has finished successfully
    And the output should be
      """
        Field name: Array
        (
            [fieldName] => empty
        )
      """

  Scenario: Translatable label
    When I run the command "form:translatable_label" and I provide as input
      | Input |
      | empty |
      | empty |
    Then the command has finished successfully
    And the output should be
      """
        Child first field: Parent second field: Array
        (
            [fieldOne] => empty
            [fieldTwo] => empty
        )
      """

  Scenario: Provide no value with no default value, value should be asked again
    When I run the command "form:name_without_default_value" and I provide as input
      | Input  |
      |        |
      | Jelmer |
    And the output should contain
      """
        Your name: Invalid data provided: name:
      """
    And the output should contain
      """
        ERROR: This value should not be blank
      """
    And the output should contain
      """
      [name] => Jelmer
      """

  Scenario: Remove an address from pre filled collection of blocked addresses
    When I run the command "form:blocked_addresses" and I provide as input
      | Input |
      |       |
      |       |
      |       |
      |       |
      |       |
      | n     |
      |       |
    And the output should contain
      """
        [street] => first street
      """
    And the output should contain
      """
        [street] => second street
      """
    And the output should not contain
      """
        [street] => third street
      """

  Scenario: Provide a value for a form with a price
    When I run the command "form:price" and I provide as input
      | Input |
      | 10.95 |
    Then the output should be
      """
      Price: Array
      (
          [price] => 10.95
      )
      """

  Scenario: Secret required field
    When I run the command "form:secret_required_field" and I provide as input
      | Input  |
      | Jelmer |
    Then the command was not successful
    And the output should contain
      """
        Invalid data provided: ERROR: This value should not be blank.
      """
    And the output should contain
      """
      Errors out of the form's scope - do you have validation constraints on properties not used in the form? (Violations on unused fields: data.fieldNotUsedInTheForm)
      """

  Scenario: Checkbox field - answer yes
    When I run the command "form:coffee" and I provide as input
      | Input |
      | y     |
    Then the command has finished successfully
    And the output should be
    """
    Do you want milk in your coffee?: Array
    (
        [milk] => 1
    )
    """

  Scenario: Checkbox field - answer no
    When I run the command "form:coffee" and I provide as input
      | Input |
      | n     |
    Then the command has finished successfully
    And the output should be
    """
    Do you want milk in your coffee?: Array
    (
        [milk] =>
    )
    """

  Scenario: Choice with options which cannot be converted to string
    When I run the command "form:unstringable_choices" and I provide as input
      | Input                    |
      | 1600 Pennsylvania Ave NW |
    Then the command has finished successfully
    And the output should contain
      """
      Select address:
        [0] 10 Downing Street
        [1] 1600 Pennsylvania Ave NW
        [2] 55 Rue du Faubourg Saint-Honoré
       >
      """
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

  Scenario: Choice with default value which cannot be converted to string
    When I run the command "form:unstringable_choices" and I provide as input
      | Input |
      |       |
    Then the command has finished successfully
    And the output should contain
      """
      Select address:
        [0] 10 Downing Street
        [1] 1600 Pennsylvania Ave NW
        [2] 55 Rue du Faubourg Saint-Honoré
       >
      """
    And the output should contain
      """
      Array
      (
        [address] => Matthias\SymfonyConsoleForm\Tests\Form\Data\Address Object
          (
            [street] => 10 Downing Street
          )
      )
      """

  Scenario: Choice with object options in interactive mode
    Given I run the command "form:unstringable_choices_with_values" and I provide as input "55-rue-du-faubourg-saint-honoré" with parameters
      | Parameter   | Value                    |
      | --address   | 1600-pennsylvania-ave-nw |
    Then the command has finished successfully
    And the output should contain
      """
      Select address [1600-pennsylvania-ave-nw]:
        [10-downing-street              ] 10 Downing Street
        [1600-pennsylvania-ave-nw       ] 1600 Pennsylvania Ave NW
        [55-rue-du-faubourg-saint-honoré] 55 Rue du Faubourg Saint-Honoré
       >
      """
    And the output should contain
      """
      Array
      (
        [address] => Matthias\SymfonyConsoleForm\Tests\Form\Data\Address Object
          (
            [street] => 55 Rue du Faubourg Saint-Honoré
          )
      )
      """

  Scenario: Command with default form data
    When I run the command "form:default_value_command" and I provide as input
      | Input |
      | foo   |
    And the output should contain
      """
        Street [already save address]:
      """
    And the output should contain
      """
        Array
        (
            [street] => foo
        )
      """
