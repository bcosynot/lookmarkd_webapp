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

CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FE2904019 (thread_id), INDEX IDX_B6BD307FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE message_metadata (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_4632F005537A1329 (message_id), INDEX IDX_4632F0059D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE thread (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, is_spam TINYINT(1) NOT NULL, INDEX IDX_31204C83B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE thread_metadata (id INT AUTO_INCREMENT NOT NULL, thread_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, last_participant_message_date DATETIME DEFAULT NULL, last_message_date DATETIME DEFAULT NULL, INDEX IDX_40A577C8E2904019 (thread_id), INDEX IDX_40A577C89D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id);
ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES fos_user (id);
ALTER TABLE message_metadata ADD CONSTRAINT FK_4632F005537A1329 FOREIGN KEY (message_id) REFERENCES message (id);
ALTER TABLE message_metadata ADD CONSTRAINT FK_4632F0059D1C3019 FOREIGN KEY (participant_id) REFERENCES fos_user (id);
ALTER TABLE thread ADD CONSTRAINT FK_31204C83B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id);
ALTER TABLE thread_metadata ADD CONSTRAINT FK_40A577C8E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id);
ALTER TABLE thread_metadata ADD CONSTRAINT FK_40A577C89D1C3019 FOREIGN KEY (participant_id) REFERENCES fos_user (id);

CREATE TABLE connections (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_BFF6FC153AD8644E (user_source), INDEX IDX_BFF6FC15233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE connections ADD CONSTRAINT FK_BFF6FC153AD8644E FOREIGN KEY (user_source) REFERENCES fos_user (id) ON DELETE CASCADE;
ALTER TABLE connections ADD CONSTRAINT FK_BFF6FC15233D34C1 FOREIGN KEY (user_target) REFERENCES fos_user (id) ON DELETE;

ALTER TABLE `fos_user` CHANGE `instagram_id` `instagram_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, CHANGE `instagram_access_token` `instagram_access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `instagram_id`, `instagram_access_token`) VALUES (NULL, 'lookmarkd', 'lookmarkd', 'lookmarkd@gmail.com', 'lookmarkd@gmail.com', '1', 'nivmcgis2msowgsko8goowkcoogskkg', '$2y$13$nivmcgis2msowgsko8goouB1VJwoixn6Noj8QAkgFGHuwdggttzma', NULL, '0', '0', NULL, NULL, NULL, 'a:0:{}', '0', NULL, NULL, NULL);

CREATE TABLE user_preference (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, preference_key VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_FA0E76BFA76ED395 (user_id), UNIQUE INDEX unique_preference (user_id, preference_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);