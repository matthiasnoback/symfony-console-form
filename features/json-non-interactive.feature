Feature: It is possible to interactively fill in a form from the CLI

  Scenario: Create a json template
    When I run the command "matthias:form:json_template 'Matthias\\SymfonyConsoleForm\\Tests\\Form\\RegularFormType'" non-interactively
    Then the output should contain
      """
      {
        "regular_form": {
          "password": {
              "password": {
                  "first": "password data",
                  "second": "password data"
              }
          },
          "name": "Matthias",
          "addresses": [
              {
                  "street": "dummy data"
              }
          ],
          "email": "dummy@dummy.com",
          "country": "AF",
          "dateOfBirth": "1879-03-14"
        }
      }
      """

  Scenario: Use a json template to fill form
    When I run the command 'form:regular_form --json-data='{"regular_form":{"password":{"password":{"first":"password data","second":"password data"}},"name":"Matthias","addresses":[{"street":"dummy data"}],"email":"dummy@dummy.com","country":"AF","dateOfBirth":"1879-03-14"}}'' non-interactively
    Then the output should be
    """
    Matthias\SymfonyConsoleForm\Tests\Form\Data\Demo Object
      (
    [name] => Matthias
    [password] => Array
        (
            [password] => password data
        )

    [email] => dummy@dummy.com
    [country] => AF
    [addresses] => Array
        (
          [0] => Matthias\SymfonyConsoleForm\Tests\Form\Data\Address Object
            (
                [street] => dummy data
            )

        )
    [dateOfBirth] => DateTime Object
        (
            [date] => 1879-03-14 00:00:00.000000
            [timezone_type] => 1
            [timezone] => +00:00
        )
    )
      """

  Scenario: Use a json template to fill form loaded by FormHelperCommand
    When I run the command 'form:regular_form_standard_load --json-data='{"regular_form":{"password":{"password":{"first":"password data","second":"password data"}},"name":"Matthias","addresses":[{"street":"dummy data"}],"email":"dummy@dummy.com","country":"AF","dateOfBirth":"1879-03-14"}}'' non-interactively
    Then the output should be
    """
    Matthias\SymfonyConsoleForm\Tests\Form\Data\Demo Object
      (
    [name] => Matthias
    [password] => Array
        (
            [password] => password data
        )

    [email] => dummy@dummy.com
    [country] => AF
    [addresses] => Array
        (
          [0] => Matthias\SymfonyConsoleForm\Tests\Form\Data\Address Object
            (
                [street] => dummy data
            )

        )
    [dateOfBirth] => DateTime Object
        (
            [date] => 1879-03-14 00:00:00.000000
            [timezone_type] => 1
            [timezone] => +00:00
        )
    )
      """

