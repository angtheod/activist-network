## General information

This project is -Not- supposed to be an example of applying SOLID practices, but more of a small task playing with mechanisms like
recursion, hash tables, custom autoloader, unit testing and some more.

No framework, no data persistence, no docker here. Has a UI, as can be seen in the example.png. Has Unit tests that can be run with phpunit.

In a project running on production environment we would use a secure connection to the server (SSL)
add Input sanitization, data validation, escape output add protection against CSRF attack, XSS attack, SQL injection.

## Usage
```
git clone git@github.com:angtheod/activist-network.git activist-network
```
Clone the Activist Network repository for local testing. Edit the data.json file to add/remove/update existing actions, activists and signed actions.

Description
---------------------------
We say that two activists who signed the same action have 1 degree of separation.
We say that two activists who each have 1 degree of separation with the same activist,
but who did not themselves sign the same action, have 2 degrees of separation.  Etc.

Write a function that takes an activist as an argument, and that first prints out all activists
who have 1 degree of separation from that activist, then prints out all activists that have 2 degrees of separation (from that activist?),
then 3, etc.  It should never print the same activist twice.

Implementation
---------------------------
We will implement this by using a HashTable.
The HashTable has the activist name as key and the activist object as node.
Each node has parent node (except for the root node) and possibly children nodes.
Tested with php 7.3.33 and 8.1.5

Tests
---------------------------
Run unit tests using phpunit required by composer
```
vendor/bin/phpunit tests/unit/ActivistNetworkTest.php
vendor/bin/phpunit tests/unit/ActionTest.php
vendor/bin/phpunit tests/unit/ActivityTest.php
```
