SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `blogdemo2db`
--

--
-- 表的结构 `adminuser`
--
CREATE TABLE IF NOT EXISTS `adminuser` (
  `id`       INT(11)                              NOT NULL,
  `username` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `email`    VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `profile`  TEXT COLLATE utf8_unicode_ci
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id`          INT(11)                              NOT NULL,
  `content`     TEXT COLLATE utf8_unicode_ci         NOT NULL,
  `status`      INT(11)                              NOT NULL,
  `create_time` INT(11) DEFAULT NULL,
  `userid`      INT(11)                              NOT NULL,
  `email`       VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `url`         VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `post_id`     INT(11)                              NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 表的结构 `commentstatus`
--

CREATE TABLE IF NOT EXISTS `commentstatus` (
  `id`       INT(11)                              NOT NULL,
  `name`     VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` INT(11)                              NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 转存表中的数据 `commentstatus`
--

INSERT INTO `commentstatus` (`id`, `name`, `position`) VALUES
  (1, '待审核', 1),
  (2, '已审核', 2);

--
-- 表的结构 `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version`    VARCHAR(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` INT(10) DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id`          INT(11)                              NOT NULL,
  `title`       VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `content`     TEXT COLLATE utf8_unicode_ci         NOT NULL,
  `tags`        TEXT COLLATE utf8_unicode_ci,
  `status`      INT(11)                              NOT NULL,
  `create_time` INT(11) DEFAULT NULL,
  `update_time` INT(11) DEFAULT NULL,
  `author_id`   INT(11)                              NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 表的结构 `user`
--

# CREATE TABLE IF NOT EXISTS `user` (
#   `id`                   INT(11)                              NOT NULL,
#   `username`             VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
#   `auth_key`             VARCHAR(32) COLLATE utf8_unicode_ci  NOT NULL,
#   `password_hash`        VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
#   `password_reset_token` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
#   `email`                VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
#   `status`               SMALLINT(6)                          NOT NULL DEFAULT '10',
#   `created_at`           INT(11)                              NOT NULL,
#   `updated_at`           INT(11)                              NOT NULL
# )
#   ENGINE = InnoDB
#   AUTO_INCREMENT = 1
#   DEFAULT CHARSET = utf8
#   COLLATE = utf8_unicode_ci;

--
-- Indexes for table `adminuser`
--

--
-- 表的结构 `poststatus`
--

CREATE TABLE IF NOT EXISTS `poststatus` (
  `id`       INT(11)                              NOT NULL,
  `name`     VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` INT(11)                              NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- 转存表中的数据 `poststatus`
--

INSERT INTO `poststatus` (`id`, `name`, `position`) VALUES
  (1, '草稿', 1),
  (2, '已发布', 2),
  (3, '已归档', 3);

CREATE TABLE IF NOT EXISTS `tag` (
  `id`        INT(11)                              NOT NULL,
  `name`      VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` INT(11) DEFAULT '1'
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--

ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comment_post` (`post_id`),
  ADD KEY `FK_comment_user` (`userid`),
  ADD KEY `FK_comment_status` (`status`);

--
-- Indexes for table `commentstatus`
--

ALTER TABLE `commentstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
-- ALTER TABLE `migration`
-- ADD PRIMARY KEY (`version`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_post_author` (`author_id`),
  ADD KEY `FK_post_status` (`status`);

--
-- Indexes for table `poststatus`
--
ALTER TABLE `poststatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--

ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--

# ALTER TABLE `user`
#   ADD PRIMARY KEY (`id`),
#   ADD UNIQUE KEY `username` (`username`),
#   ADD UNIQUE KEY `email` (`email`),
#   ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- 限制表 `comment`
--

ALTER TABLE `comment`
  ADD CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `FK_comment_status` FOREIGN KEY (`status`) REFERENCES `commentstatus`
(`id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
  ON DELETE CASCADE;

--
-- 限制表 `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_post_author` FOREIGN KEY (`author_id`) REFERENCES `adminuser` (`id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `FK_post_status` FOREIGN KEY (`status`) REFERENCES `poststatus` (`id`)
  ON DELETE CASCADE;

