# spqt-backend-work-sample-parser

Backend work sample configuration parser.

See https://github.com/spqt/backend-work-sample-parser.

## Purpose

Parse a configuration file.

## What it does

See Purpose.

## How it works

It opens the configurations and parses it using regular expressions
and recursive functions.

## Requirements / tested on

- PHP

## Getting Started

These instructions will get you a copy of the project up and running on your
local machine for development and testing purposes. See deployment for notes on
how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
- PHP
```

Setup PHP.

In short: apt-get install php.

### Installing

Head to a directory and clone the repository:

```
git clone https://github.com/dotpointer/spqt-backend-work-sample-parser.git
cd spqt-backend-work-sample-parser/
```

## Usage

Run the parser.php in a terminal using PHP:

php parser.php

## Notes

There are hidden characters on the following lines in the configuration file:
db.name.internal = "db­01­internal.local"
db.name.external = "db­01.company.tld"

The hidden characters are located between db and 01 and they are UTF-8 C2 and AD.
Removing them will however not make the strings as long as required in the var_dump
example where they are 17 and 20 but the output from this parser is 22 and 18.

There is a missing line in the configuration file that is shown in the var_dump example:
cache.connection.timeout = 3

The script compensates for this and adds it if it is missing.

## Authors

* **Robert Klebe** - *Development* - [dotpointer](https://github.com/dotpointer)

## License

This project is licensed under the MIT License - see the
[LICENSE.md](LICENSE.md) file for details.

Contains dependency files that may be licensed under their own respective
licenses.
