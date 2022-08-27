# Tatter\Repositories
Strict repository pattern classes for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-repositories/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-repositories/actions/workflows/phpunit.yml)
[![](https://github.com/tattersoftware/codeigniter4-repositories/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-repositories/actions/workflows/phpstan.yml)
[![](https://github.com/tattersoftware/codeigniter4-repositories/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-repositories/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-repositories/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-repositories?branch=develop)

## Quick Start

1. Install with Composer: `> composer require tatter/repositories`
2. Create your Entities extending `Tatter\Repository\Entity`
3. Create your Repositories implementing `Tatter\Repository\RepositoryInterface`

## Description

**Repositories** is an alternate take on the data access layer for CodeIgniter 4. Following the
[Repository Design Pattern](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html),
these classes work as a 1:1 replacement for your traditional framework Models, or as a part
of a larger unit-of-work structure for [Domain Driven Design](https://thedomaindrivendesign.io/what-is-ddd/).

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require tatter/repositories`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

## Usage

More docs coming soon! In the meantime, see the example classes in [Testing](/tests/_support/Repositories)
for inspiration.

## Development & Support

Pull Requests and Bug Reports are gladly accepted! Any feedback, suggestions, and general
discussions should be in [Discussions](https://github.com/tattersoftware/codeigniter4-repositories/discussions).

New feature requests and support questions should be opened as a discussion first and will be
moved to Issues as necessary. There is no guarantee that these will be addressed, but priority
will be given based on sponsorship (see "Sponsor this project").
