Anketa
============================

[Yii 2](http://www.yiiframework.com/)

Настройки
-------------

### Database

```sql
CREATE TABLE IF NOT EXISTS `anketa`.`user` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	`username` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
	`password` VARCHAR(33) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
	`role` ENUM('user','admin','superadmin') NOT NULL DEFAULT 'user' ,
	`auth_key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
	PRIMARY KEY (`id`)
 ) ENGINE = InnoDB;

 CREATE TABLE IF NOT EXISTS `anketa`.`ankets` (
	 `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
	 `table_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
	 `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
	 PRIMARY KEY (`id`)
 ) ENGINE = InnoDB;

 CREATE TABLE IF NOT EXISTS `anketa`.`user_answers` (
	 `ankets_id` INT(5) NOT NULL ,
	 `user_id` INT(5) NOT NULL ,
	 PRIMARY KEY (`ankets_id`, `user_id`)
 ) ENGINE = InnoDB;
```

**Заметки:**
- Не стоит удалять пользователей, заполнивших анкеты :)