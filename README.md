cupcake
=======

An insecure small PHP framework based loosely off of CakePHP and intended for intranet deployment 


Request path
------------

- .htaccess rewrites all requests to index.php
- index.php defines a Dispatcher and runs it
- Dispatcher digests path handed to it by the .htaccess rewrite and runs a controller/method combo
- Controller->Method URL path syntax is "controller/method" (#woah #wow)
- Ajax support is half assed and/or broken right now.
