SimLog
======
Simlog is a simple blogging engine I built to power my website, [diarmuid.ie](http://diarmuid.ie). It is built using the [Codeigniter](http://ellislab.com/codeigniter) framework and [Bootstrap](http://getbootstrap.com/) for admin screen styling.

### Features
* Markdown post editing.
* Static page caching.
* Media upload and management.
* Not much else!

### Can I use this for my own blog?
Of course! However I wouldn't recommend it. I built SimLog to meet my own requirements and because of that there are lots of features that you might need missing. You would be better off using one of the many other PHP blog systems out there. The main reason for publishing my code is so that others might learn from it. Feel free to build upon this code or take bits of it to build your own blog software.

## Version

0.1

## Tech

SimLog uses a number of open source projects to work properly:

### Backend
* [Codeigniter](http://ellislab.com/codeigniter) - A Simple PHP MVC framework.
* [PHP Markdown](https://github.com/dflydev/dflydev-markdown) - A PHP markdown to HTML processor.

### Frontend
* [bootstrap](http://getbootstrap.com/) - Frontend UI framework. Used for the admin screens.
* [EpicEditor](http://epiceditor.com/) - An embeddable markdown editor and previewer.
* [typeahead.js](http://twitter.github.io/typeahead.js/) - Twitters autocomplete library. Used to autocomplete tags in the admin screens.
* [jQuery](http://jquery.com) - Needs no introduction.
* [bootstrap-tagsinput](http://timschlechter.github.io/bootstrap-tagsinput/examples/) - An addon to Bootstrap to allow tag input.
* [retina.js](http://retinajs.com/) - Small JS library to swap out regular images for retina ready ones if available.
* [highlightjs](http://highlightjs.org/) - Syntax highlighting for blog posts with code samples.

## Installation

All the project dependencies are handelled with [Bower](http://bower.io/) (Frontend dependency management) and [Composer](http://getcomposer.org/) (PHP dependency management). Make sure you have both these tools installed before going any further.

### Clone Repo
First step is to clone this repo.
```sh
git clone [git-repo-url] 
```
### Load dependencies
Next we will load our dependencies.:
```sh
cd simlog
composer install
bower install
```
### Build database
create a new database in MySQL called simlog (or whatever you want really) and execute the contents of the <code>schema.sql</code> file.

### Create config files
in <code>simlog/application/config</code> create a folder called 'development' (or 'production if you are deploying to production). In this folder create a copy of:

* _basic_auth.php_ - This file is used to store the authentication settings for the admin section of the site.
* _config.php_ - The main codeigniter config file.
* _database.php_ - Stores the database connection configuration.



### Configure Webserver
Point the webroot of your webserver at <code>simlog/www</code>. If you are using Apache you can rename the <code>example.htaccess</code> to just <code>.htaccess</code>.

If you are using nginx then below is the server block I use to serve the site using FastCGI:

```
server {
    ...
    
    root			/var/www/simlog/www;
	autoindex		on;
	index			index.php;

	location / {
		try_files $uri $uri/ /index.php;

		location = /index.php {
			fastcgi_pass	unix:/var/run/php5-fpm.sock;
			fastcgi_index	index.php;
			fastcgi_param	CI_ENV production;
			include	fastcgi_params;
		}
 	}
     
     ...
}
```

License
----

MIT