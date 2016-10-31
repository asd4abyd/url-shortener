CREATE TABLE bots_host
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    host VARCHAR(255) NOT NULL
);
CREATE TABLE bots_ip
(
    ip VARCHAR(50) PRIMARY KEY NOT NULL,
    last_connection INT DEFAULT 0,
    block INT DEFAULT 0,
    admin_status INT DEFAULT 0
);
CREATE TABLE bots_log
(
    ip VARCHAR(50),
    date INT,
    link_id INT,
    user_agent VARCHAR(255),
    referer VARCHAR(255)
);
CREATE TABLE bots_settings
(
    `key` VARCHAR(20) PRIMARY KEY NOT NULL,
    value VARCHAR(150)
);
CREATE TABLE redirect_links
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    link LONGTEXT NOT NULL,
    encrypt LONGTEXT,
    `html` LONGTEXT
);
CREATE INDEX date_index ON bots_log (date);
CREATE INDEX ip_index ON bots_log (ip);
CREATE INDEX link_index ON bots_log (link_id);


INSERT INTO bots_settings (`key`, value) VALUES ('connections per hour', '20');
INSERT INTO bots_settings (`key`, value) VALUES ('redirect', 'http://www.luxury-retreats.net/');
INSERT INTO bots_settings (`key`, value) VALUES ('use captcha', 'false');
INSERT INTO bots_settings (`key`, value) VALUES ('Secret Key', '6LfP3A8TAAAAABdGg90GqhF-u2jqLzvC5j31o01m');
INSERT INTO bots_settings (`key`, value) VALUES ('Site Key', '6LfP3A8TAAAAAC8kWO5C8G2pJkEMT6sbRpgky3Sz');
INSERT INTO bots_settings (`key`, value) VALUES ('password', 'e10adc3949ba59abbe56e057f20f883e');
