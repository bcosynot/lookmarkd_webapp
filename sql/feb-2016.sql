ALTER TABLE `fos_user` CHANGE `instagram_id` `instagram_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `fos_user` CHANGE `instagram_access_token` `instagram_access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

CREATE TABLE campaign (id INT AUTO_INCREMENT NOT NULL, campaignName VARCHAR(255) NOT NULL, owner BIGINT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, reward_type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE campaign_participants (id INT AUTO_INCREMENT NOT NULL, campaign INT NOT NULL, participant INT NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE social_statistic (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, provider_type VARCHAR(255) NOT NULL, statistics_type INT NOT NULL, recordedAt DATETIME NOT NULL, statistic BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;