If you want to contribute to this library, clone this project, then:

- Run `composer install` to install dependencies.
- Run `./install-git-hooks.sh` to install the pre-commit hook which fixes coding style problems automatically for you.

Take a look at `.travis.yml` to find out which versions of Symfony are currently supported by this library. The easiest way to find out if your code changes are compatible with different versions of Symfony is to register your cloned repository at Travis. Then push your code to GitHub and wait for the Travis build to finish. If the build fails for a particular Symfony version you can reproduce the build locally by exporting the same environment variables as Travis does and running the install and test scripts on your machine.
