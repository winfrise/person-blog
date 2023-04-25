ALTER TABLE le_comment ADD is_status tinyint (2) NOT NULL DEFAULT 0;
INSERT INTO le_setting VALUES ('comment_examine','1');