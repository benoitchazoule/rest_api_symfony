# Symfoni rest API test ![in progress](https://img.shields.io/badge/symfony_api_test-in_progress-blue.svg?style=flat)
This is a test project of REST API creation in order to build skills on symfony.

## Description
This API permit interact with places and users and list suggestions of places for one user with preferences themes specified.

## Features
* use of FOSRestBundle
* securisation with tokens
* support of multiple Content-Type
* management of query strings on Place collection
* use of JMSSerialzerBundle
* use of NelmioApiDocBundle

## Configuration
To use this API you must have this configuration:

Technology  |Version 
------------|:--------:
PHP         |7.0.x 
MySQL       |5.7.x
Apache      |2.4.x

You have to create a virtual host `rest-api.local` in order to access API with the url `http://rest-api.local`

## Documentation
The documentation is generated with NelmioApiDocBundle. It's not complete but accessible with the URL `http://rest-api.local/documentation`
![Screenshot api doc](https://i.imgur.com/WO1EUOX.png)