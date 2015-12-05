CREATE TABLE social_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, provider_type VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) NOT NULL, INDEX IDX_E2C7F92A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, instagram_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D95AB405A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE social_profile ADD CONSTRAINT FK_E2C7F92A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);
ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);
ALTER TABLE fos_user ADD instagram_access_token VARCHAR(255) NOT NULL;

CREATE TABLE posting_category (id INT AUTO_INCREMENT NOT NULL, categoryName VARCHAR(255) NOT NULL, categoryDescription VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE user_posting_category (user_profile_id INT NOT NULL, posting_category_id INT NOT NULL, INDEX IDX_FEDA00C26B9DD454 (user_profile_id), INDEX IDX_FEDA00C2B8AFD358 (posting_category_id), PRIMARY KEY(user_profile_id, posting_category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE user_posting_category ADD CONSTRAINT FK_FEDA00C26B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profile (id) ON DELETE CASCADE;
ALTER TABLE user_posting_category ADD CONSTRAINT FK_FEDA00C2B8AFD358 FOREIGN KEY (posting_category_id) REFERENCES posting_category (id) ON DELETE CASCADE;

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('1', 'Fashion', 'Fashion');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('2', 'Beauty', 'Beauty');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('3', 'Luxury', 'Luxury');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('4', 'Travel', 'Travel');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('5', 'Sports', 'Sports');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('6', 'Gadgets', 'Gadgets');

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('7', 'Entertainment', 'Entertainment');

UPDATE `posting_category` SET `categoryName` = 'Technology', `categoryDescription` = 'Technology' WHERE `posting_category`.`id` = 6;

INSERT INTO `posting_category` (`id`, `categoryName`, `categoryDescription`) VALUES ('8', 'Arts', 'Arts');

ALTER TABLE user_profile ADD blogger_name VARCHAR(255) NOT NULL;

ALTER TABLE `user_profile` CHANGE `first_name` `first_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, CHANGE `last_name` `last_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, CHANGE `blogger_name` `blogger_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `social_profile` CHANGE `profile_picture` `profile_picture` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

CREATE TABLE user_preference (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, preference_key VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_FA0E76BFA76ED395 (user_id), UNIQUE INDEX unique_preference (user_id, preference_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);