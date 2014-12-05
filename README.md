# Symfony Minimal Edition

Symfony ME (pun not intended) is an opinionated minimal base install
of the [Symfony2](http://symfony.com) framework - sort of a middle ground between
using Silex and the full blown Symfony SE install.
Some concepts are heavily inspired by
[Benjamin's post](http://www.whitewashing.de/2014/10/26/symfony_all_the_things_web.html)
on the subject.

For experienced Symfony2 developers, ME provides a clean starting point where you
only add what you need.
On the other hand, newcomers to Symfony2 can use this as a playground to
understand how the full stack framework can be set up manually and in
non-standard ways.

__Disclaimer__: This is not an official Symfony distribution, just a
private project. While it is perfectly possible to build production projects
on Symfony ME, it lacks some features from Symfony SE that are meant to
enable SE to be used in a broad range of environments (for example, ME lacks
the bootstrap.php.cache). If you use this for more than educational purposes,
it is assumed that you know what you are doing.

The main differences compared to the
[Symfony Standard Edition](https://github.com/symfony/symfony-standard) are:


### Bundles

Symfony ME comes with the Symfony core bundles plus the MonologBundle.
Most other tools such as Assetic, FrameworkExtraBundle, Swiftmailer,
Doctrine, etc. are missing from a default install.


### Configuration

Following [12 factor app](http://12factor.net/) recommendations, all
infrastructure parameters are configured using environment variables,
down to setting the debug flag and the environment name.
In consequence, there is no parameters.yml and the configuration file
structure is simplified compared to Symfony SE.

To facilitate easy development with this approach, the kernel will use
[PHP dotenv](https://github.com/vlucas/phpdotenv) to load environment vars if
no ```SYMFONY_ENV``` var is found in the environment, or when the app is running
using the built-in webserver. The names used for the environment variable checks
can be set in the front controller when calling the kernel constructor.

For any kind of deployment other than development, configuration should
take place exclusively through environment variables. No code or file changes
from development are required.


### Files and folder structure

Symfony ME uses a Symfony 3.0 inspired directory structure:

- The ```console``` script is found in the ```bin``` directory
- The ```app/cache``` and ```app/log``` directories have been moved to ```var```
- There is only a single index.php front controller
- No .htaccess file included


## Installation

Create a project:

    $ composer create-project -s beta monkeycode/minisf myproject

Symfony ME does not come with the ```SensioDistributionBundle``` or other
composer script handlers. Therefore you also need to run:

    $ cp .env.dist .env
    $ bin/console assets:install --symlink

That's it, you're good to go.