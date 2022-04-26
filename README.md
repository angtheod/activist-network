## General information

```
git clone git@github.com:angtheod/activist-network.git activist-network
```
Clone the Activist Network repository and test locally and edit the data.json file to add/remove/update existing actions, activists and signed actions.

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
Each node has _parent node (except for the root node) and possibly children nodes.
Tested with php 7.3.33

Notes
---------------------------
In a project running on production environment we would
use a secure connection to the server (SSL)
add Input Validation and also
add protection against CSRF attack, XSS attack, SQL injection.
