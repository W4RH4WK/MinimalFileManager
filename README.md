# Phoenix Template

### Description
This projects aims to be starting template for simple web pages. It's built on
top of the silex micro framework. Even though a file manager with editor is
present, the recommended way of alerting content would be handling the files
directly or via ftp. This encourages you to use your favorite editor.

### Used Components
 - [Bootstrap](http://twitter.github.com/bootstrap/)
 - [CKEditor](http://ckeditor.com/)
 - [Flowplayer](http://flowplayer.org/)
 - [Font Awesome](http://fortawesome.github.com/Font-Awesome/)
 - [Jquery](http://jquery.com/)
 - [Lightbox](http://lokeshdhakar.com/projects/lightbox2/)
 - [Markdown](http://michelf.ca/projects/php-markdown/)

### Features
 - **no database needed --> everything is a file**
 - static pages with HTML or Markdown
 - blog working out of the box
 - gallery with automatic thumbnail creation
 - file section
 - user authentication
 - handcrafted file manager with WYSIWYG editor

### Installation
Composer is used for the installation so process. The `composer.json` file is
part of the project just run composer.

    $ git clone git://github.com/W4RH4WK/phoenix-tpl.git ptpl
    $ cd ptpl
    $ php composer install

Change the url inside the `app/app.php`.

$app['url'] = 'http://example.org/';

Point your web server to the `web` directory.

### How to add content
All content should be kept inside the `data` folder. Some example content has
been created for you. If you encounter problems do not hesitate looking at the
code, I tried keeping it clean and simple.

### How to customize the navigation
The navigation bar on top of the page is pulled from the file `data/nav.html`

### How to customize the page
The two main files you want to look at are `tpl/layout.html.twig` and
`web/assets/default.css`. If you want to change the component specific look,
checkout the corresponding template inside the `tpl` folder.

My logo is used as placeholder in this project, just replace the files inside
`web/assets/gfx`.

Another way to easily customize the web page would be creating your own version
of bootstrap and replace the content inside `web/assets/bootstrap`.

### How to add a user
All users are stored inside `data/passwd.json`. In order to add a user, use the
script inside the `utils` folder.

    $ php utils/usermgmt.php warhawk

The first parameter is the username, it will prompt for a password.

### How to login
`http://example.org/user/login` upon browsing to `user/login` a login box is
shown. After entering valid credentials two new buttons should appear on the
right side of the navigation. One of the is the logout button.

I already created a default user with username `root` and password `toor`.

### License
I provide assets like bootstrap and flowplayer as they are to ensure better out
of the box experience. This way you do not have to install them manually.

    Copyright (c) 2013 Alex W4RH4WK Hirsch

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
