## Running Coding Standards Checks

This component uses [php-cs-fixer](http://cs.sensiolabs.org/) for coding
standards checks, and provides configuration for our selected checks.
`php-cs-fixer` is installed by default via Composer.

To run checks only:

```console
$ ./vendor/bin/php-cs-fixer fix . -v --diff --dry-run --config-file=.php_cs
```

To have `php-cs-fixer` attempt to fix problems for you, omit the `--dry-run`
flag:

```console
$ ./vendor/bin/php-cs-fixer fix . -v --diff --config-file=.php_cs
```

If you allow php-cs-fixer to fix CS issues, please re-run the tests to ensure
they pass, and make sure you add and commit the changes after verification.
