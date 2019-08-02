# Holded Dashboard

This sample project was developed to be a quick demo of implementing a Dashboard

## Tech stack
* PHP 7
* Slim
* Javascript
* jQuery
* MongoDB

## Features
* Authentication system (Signin + Signup)
* Dashboard
  * Grid system (implemented via 3rd party library [gridstack.js](http://gridstackjs.com/)), the same [Holded](https://www.holded.com/) uses in Production.
  * Widgets (CRUD)
    * Title
	* Background color

## TODO
Here is a list of tasks that should be done if this were a serious project (i.e not a demo)
* Make it fully responsive
* Improve UI
* Unit testing
* Use Module Bundler for the frontend assets (e.g. Webpack)
* Use Sass to improve code quality and modularity regarding styles
* Add data validations

## Install the Application
Make sure you have installed all dependencies required in this project beforehand.

Run:

```bash
$ composer install
$ php -S 0.0.0.0:8080
```