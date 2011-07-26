INSERT INTO mytable (id, bar) VALUES (1, 'hallo welt');

-- or use different quotes
INSERT INTO `mytable` (`id`, `bar`) VALUES (1, "hallo welt");

CREATE TABLE bar (
  id INT AUTO_INCREMENT,
  PRIMARY KEY(id)
);