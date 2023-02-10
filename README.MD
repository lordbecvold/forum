## Becvold forum
Becvold forum is a classic forum with a minimum of javascript designed overall for maximum security and performance.
{img} {admin_sys_img}

## Installation
- Set web root to web dir public/
- Disable apache autoindex
- Run install script
- Insert database structure to mysql
* next_install_instruction

## Rank system
* rank_system_info

## Config
* config_instruction

## Theme
* custom_theme_file_desc

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
- [ ] Registred date & last login date in profile browser
- [ ] Highlight links in post (only for logged users)
- [ ] show image from image link (imgur, ctrlv.cz etc)
- [ ] Post editor (for admin & post owner)
- [ ] Post delete (for admin & post owner)
- [ ] Search system (where post name)
- [ ] Add loging actions (mysql log)
- [ ] Ban/mute system
- [ ] Test & fix CSS responsivity
- [ ] Admin system (edit forum category, delete posts, delete comments, ban / mute / rank change for users)
- [ ] CSS Colors in separate file (theme.css)
- [ ] Code clean
- [ ] Penetration testing

## Dependencies
This project requires PHP8 or < .
* Adminer
   * Version: **4.8.1**
   * [Website](https://www.adminer.org/)
* Whoops
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
