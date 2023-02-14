## Becvold forum
Becvold forum is a classic forum with a minimum of javascript designed overall for maximum security and performance.

## Installation
- Set web root to web dir public/
- Disable apache autoindex
- Run install script
- Insert database structure to mysql
- edit (url, https, mysql) config.php file
- register new user (default user is automatic role owner)

## Rank system
- OWNER: COLOR: red, DELETE: can delete posts & access to adminer
- ADMIN: COLOR: red, DELETE: can delete posts & access to adminer
- DEVELOPER: COLOR: blue
- VIP: COLOR: gold
- USER: COLOR: green

## DEV PLAN
- [X] Basic structure
- [X] Register system
- [X] Login system
- [X] Logout system
- [X] User system
- [X] Rank system (owner, admin, developer, vip, user)
- [X] Favicon path in config file
- [X] Default page structure with forum category
- [X] Load forum category from mysql table
- [X] sub navigation in forum browser (new post, show own posts)
- [X] Post list structure
- [X] Posts list limit (page system)
- [X] Post reader
- [X] New post compnent
- [X] Comment system
- [X] Profile page
- [X] Search system (where post name)
- [X] Highlight links in post (only for logged users)
- [X] Post delete (for admin & post owner)
- [X] Add loging actions (mysql log)
- [X] Code clean

## Dependencies
This project requires PHP8 or < .
* Adminer
   * Version: **4.8.1**
   * [Website](https://www.adminer.org/)
* Becwork
   * Becwork: **2.0**
   * [Github](https://github.com/lordbecvold/becwork)
* Whoops
   * Version: **2.14.4**
   * [Github](https://github.com/filp/whoops)
* Font-awesome
   * Version: **5.8.1 - FREE**
   * [Website](https://fontawesome.com)

## License
The framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
