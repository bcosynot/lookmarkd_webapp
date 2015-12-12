CREATE TABLE user_preference_type (id INT AUTO_INCREMENT NOT NULL, preferenceKey VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

DROP INDEX unique_preference ON user_preference;
ALTER TABLE user_preference ADD preference_type_id INT DEFAULT NULL, DROP preference_key;
ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA5A08383 FOREIGN KEY (preference_type_id) REFERENCES user_preference (id);
CREATE UNIQUE INDEX UNIQ_FA0E76BFA5A08383 ON user_preference (preference_type_id);
CREATE UNIQUE INDEX unique_preference ON user_preference (user_id, preference_type_id);


INSERT INTO `user_preference_type` (`id`, `preferenceKey`, `description`) VALUES (NULL, 'email_updates', 'Receive email about important updates and announcements from Lookmarkd.'), (NULL, 'email_notification_messages', 'Receive notifications for new messages.');

ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BFA5A08383;
ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFA5A08383 FOREIGN KEY (preference_type_id) REFERENCES user_preference_type (id);

ALTER TABLE fos_user ADD user_type INT DEFAULT NULL;