Migrationsleitfaden
===================

Die folgende Anleitung beschreibt, wie man ein bestehendes 0.6-Projekt auf 0.7
aktualisieren kann.

.. note::

  Nicht beschrieben sind die API-Änderungen, die zu Anpassungen an Modulen,
  Templates und AddOns führen. Stattdessen soll hier der grundlegende Ablauf
  beschrieben werden.

.. note::

  TODO

Datenbank
---------

Schema-Updates
~~~~~~~~~~~~~~

.. sourcecode:: mysql

  -- add temp column pairs

  ALTER TABLE `sly_article`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_article_slice`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_file`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_file_category`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`;

  ALTER TABLE `sly_user`
     ADD COLUMN `created` DATETIME NOT NULL AFTER `createdate`,
     ADD COLUMN `updated` DATETIME NOT NULL AFTER `updatedate`,
     ADD COLUMN `lasttry` DATETIME NULL AFTER `lasttrydate`;

  -- recode the existing data

  UPDATE `sly_article`       SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_article_slice` SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_file`          SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_file_category` SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`);
  UPDATE `sly_user`          SET `created` = FROM_UNIXTIME(`createdate`), `updated` = FROM_UNIXTIME(`updatedate`), `lasttry` = FROM_UNIXTIME(`lasttrydate`);

  -- remove old columns

  ALTER TABLE `sly_article`       DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_article_slice` DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_file`          DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_file_category` DROP COLUMN `createdate`, DROP COLUMN `updatedate`;
  ALTER TABLE `sly_user`          DROP COLUMN `createdate`, DROP COLUMN `updatedate`, DROP COLUMN `lasttrydate`;

  -- rename new columns

  ALTER TABLE `sly_article`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL AFTER `type`,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL AFTER `createdate`;

  ALTER TABLE `sly_article_slice`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL AFTER `article_id`,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL AFTER `createdate`;

  ALTER TABLE `sly_file`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL AFTER `title`,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL AFTER `createdate`;

  ALTER TABLE `sly_file_category`
     CHANGE COLUMN `created` `createdate` DATETIME NOT NULL AFTER `attributes`,
     CHANGE COLUMN `updated` `updatedate` DATETIME NOT NULL AFTER `createdate`;

  ALTER TABLE `sly_user`
     CHANGE COLUMN `created` `createdate`  DATETIME NOT NULL AFTER `timezone`,
     CHANGE COLUMN `updated` `updatedate`  DATETIME NOT NULL AFTER `createdate`,
     CHANGE COLUMN `lasttry` `lasttrydate` DATETIME NOT NULL AFTER `rights`;

  -- change engine to InnoDB

  ALTER TABLE `sly_article`       ENGINE=InnoDB;
  ALTER TABLE `sly_article_slice` ENGINE=InnoDB;
  ALTER TABLE `sly_clang`         ENGINE=InnoDB;
  ALTER TABLE `sly_file`          ENGINE=InnoDB;
  ALTER TABLE `sly_file_category` ENGINE=InnoDB;
  ALTER TABLE `sly_registry`      ENGINE=InnoDB;
  ALTER TABLE `sly_slice`         ENGINE=InnoDB;
  ALTER TABLE `sly_user`          ENGINE=InnoDB;
