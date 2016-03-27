Project
=======

A Symfony project created on March 16, 2016, 10:08 pm.

Steps for working solution.

1.Unzip project from https://drive.google.com/file/d/0B2LAZCksPeaSQ2lVQzdrT1NiSWs/view?usp=sharing or clone project from https://github.com/asha-tkp/project to local projects folder.
2. In command console, run composer.phar install
3. Run php app/console server:run to start server	(Server running on http://127.0.0.1:8000)
4. Run php app/console fos:js-routing:dump
5.Run app/console assetic:dump 
6. In Browser, go to http://127.0.0.1:8000/product
7. The project uses http-basic authentication. Enter username : user and password : userpass
8. Enter the url for the product feed.

###### If using php5.6+

* set always_populate_raw_post_data = -1 in php.ini

######  Running tests

Project uses phpUnit tests.
To run tests,  run :  phpunit src/AppBundle/Tests