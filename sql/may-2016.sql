ALTER TABLE campaign ADD kind_reward VARCHAR(255) NOT NULL, ADD brief VARCHAR(255) NOT NULL, ADD num_posts INT NOT NULL, ADD handles VARCHAR(255) NOT NULL, ADD hashtags VARCHAR(255) NOT NULL, ADD msg_subject VARCHAR(255) NOT NULL, ADD msg_body VARCHAR(255) NOT NULL, CHANGE start start DATETIME NOT NULL, CHANGE end end DATETIME NOT NULL, CHANGE reward_type cash_reward INT NOT NULL;

ALTER TABLE campaign CHANGE start start DATETIME NOT NULL, CHANGE end end DATETIME NOT NULL, CHANGE campaignname campaign_name VARCHAR(255) NOT NULL;
ALTER TABLE campaign_participants CHANGE campaign campaign INT NOT NULL;
ALTER TABLE `lookmarkd`.`campaign_participants` ADD INDEX `fk_campaign_campaign` (`campaign`);
ALTER TABLE `lookmarkd`.`campaign_participants` ADD INDEX `fk_participant_fos_user` (`participant`);
ALTER TABLE `campaign_participants` ADD CONSTRAINT `fk_campaign_campaign` FOREIGN KEY (`campaign`) REFERENCES `lookmarkd`.`campaign`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `campaign_participants` ADD CONSTRAINT `fk_participant_fos_user` FOREIGN KEY (`participant`) REFERENCES `lookmarkd`.`fos_user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE campaign CHANGE owner owner INT DEFAULT NULL, CHANGE start start DATETIME NOT NULL, CHANGE end end DATETIME NOT NULL;
ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DDCF60E67C FOREIGN KEY (owner) REFERENCES fos_user (id);
CREATE INDEX IDX_1F1512DDCF60E67C ON campaign (owner);

ALTER TABLE social_statistic ADD recorded_at DATETIME NOT NULL, DROP recordedAt;

ALTER TABLE campaign_participants ADD link VARCHAR(1500) NOT NULL;

ALTER TABLE campaign_participants ADD links TEXT NOT NULL COMMENT '(DC2Type:simple_array)', DROP link, CHANGE campaign campaign INT DEFAULT NULL, CHANGE participant participant INT DEFAULT NULL;

ALTER TABLE campaign_participants CHANGE links urls LONGTEXT NOT NULL COMMENT '(DC2Type:simple_array)';