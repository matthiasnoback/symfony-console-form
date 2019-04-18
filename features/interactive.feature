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
      Your date of birth [1987-03-14]: Array
      (
          [dateOfBirth] => 2015-03-04T00:00:00+0000
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

  Scenario: Select multiple values
    When I run the command "form:multi_select" and I provide as input
      """
      1,3[enter]
      """
    Then the command has finished successfully
    And the output should be
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      > Array
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
      """
      2[enter]
      """
    Then the command has finished successfully
    And the output should be
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      > Array
      (
        [choices] => Array
          (
            [1] => 2
          )
      )
      """

  Scenario: Select multiple values with multiple default values
    When I run the command "form:multi_select" and I provide as input
      """
      [enter]
      """
    Then the command has finished successfully
    And the output should be
      """
      Select values [1,2]:
        [1] AA
        [2] BB
        [3] CC
      > Array
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
      """
        empty[enter]
      """
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
      """
        empty[enter]empty[enter]
      """
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
    When I run the command "form:name_without_default_value" and I provide as input "[enter]Jelmer[enter]"
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
      """
        [enter][enter][enter][enter][enter]n[enter][enter]
      """
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
      """
      10.95[enter]
      """
    Then the output should be
      """
      Price: Array
      (
          [price] => 10.95
      )
      """

  Scenario: Secret required field
    When I run the command "form:secret_required_field" and I provide as input
      """
      Jelmer[enter]
      """
    Then the command was not successful
    And the output should contain
      """
        Invalid data provided: ERROR: This value should not be blank.
      """
    And the output should contain
      """
        [RuntimeException]
        Errors out of the form's scope - do you have validation constraints on properties not used in the form?
      """
