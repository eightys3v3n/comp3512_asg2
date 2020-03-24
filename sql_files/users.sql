DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`firstname` VARCHAR(50),
	`lastname` VARCHAR(50),
	`city` VARCHAR(50),
	`country` VARCHAR(50),
	`email` VARCHAR(50),
	`password` VARCHAR(100),
	`salt` VARCHAR(50),
	`password_sha256` VARCHAR(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (1, 'Honey', 'Kyllford', 'Calgary', 'Canada', 'hemmens0@de.vu', '$2a$12$yjPi3WJfRdW6isDC5kbojOIeY2ifQHBNgAeIVsMRTw9ZZQTrgd9gq', '048d741e931f907110adf460816ff958', '1b7f054c4c6a92aeb1813ccf0b162cab31cdb9cad0a6cd3820a724f0819af20c');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (2, 'Gaylene', 'Walenta', 'Seattle', 'United States', 'gcrannage1@mit.edu', '$2a$12$UNPEBxuR82Nuv2OZM9.g2eV2x3ZaNX4NWk9h3Rrq8QSRpP0HN/HtC', '9bce2f838034b8c8d2ba1220daef2e7e', 'b3efa8c9c09f76778fdd7f70b340c69a03d48861d2424bb5f4f4cd0d7ce11c06');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (3, 'Moyra', 'Coo', 'Chicago', 'United States', 'mbrocket2@deviantart.com', '$2a$12$n8pc33rpOJ12dvR.7n/4Ou6GOHksPwCDClr0zc9jbQcTu6XREKo4O', 'c3a10800118c3bc6c50b1ac82d31e4a6', 'b8e62ee19ebbc23976b21e0820723405e27de1d4f2fd24e4e1f456c129cee82c');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (4, 'Melisenda', 'Clissold', 'Dallas', 'United States', 'mbeekman3@patch.com', '$2a$12$AgIqWbISAAVEPl5Ef.FU1.vVcUAMRvlpSPBVQcDYIJoS.dQhkpEQy', 'd24e7731e8051cf253ca8e89e0dd0be9', 'e7a6803fc7d3db79780e300167aa8d05efebcffe5dba3a760f4f8eafe84a1af6');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (5, 'Shaina', 'Houlaghan', 'Calgary', 'Canada', 'sfolbigg4@histats.com', '$2a$12$7FAHiU8MZ0TWYSzCoEs9QuupaHDXi6rU/2HipQ5y1j8FMoYAsDUjO', 'b3f2be95228f481bc544154fa77b56c6', 'c7c097bac3f74fb336965b98de2aa84afa6bae00651761be7277bc464869efce');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (6, 'Annadiane', 'Humpage', 'Birmingham', 'United States', 'abaudic5@yellowpages.com', '$2a$12$mkQHYXC9CnTJxg8eucQ.T.Xk4q3O3GsKYUJcJi.8ygN4auxyRUBRy', '231e1ed0db2b5dc8193ac7c78071aea4', '62f5f09daf08a97ef8471d76ebf625bdaab121451bfd062d5a138bf04e30f8a1');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (7, 'Heath', 'Craney', 'Denver', 'United States', 'hpenbarthy6@nationalgeographic.com', '$2a$12$BUuPYqcWhK2BVjCX7ExY0.wykg5LkrPBz6LocY5nFBzS9tn3Bmtyy', '7f9301cbee13b0afb7e7c79aa65c9483', 'ee3f23dcb0a13743fc84384ab46244b03ede2ee1bc56f6c77af906140fc78f94');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (8, 'Ronnica', 'MacGorley', 'Boston', 'United States', 'rlamas7@nyu.edu', '$2a$12$akF7oZNNwd5Cuo.G50IIOOtE9fkmQHM/F3w1z/riMroeivI2VWrIS', '1fc0e8b9a5704994608c34a189228f51', 'fb78347933ba30fd2ac53bd1d98581bbd612721f2ca177e87913c5a7773e6e40');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (9, 'Lynn', 'Wignall', 'New York City', 'United States', 'lbroadbury8@smugmug.com', '$2a$12$0tojOMLthIV1Uj0/YIIi1ujPUv89/Z.gn3.cU/chlINOg4vLSpfwq', '23a56dcf9c599bf803f2b7abf1db4b79', 'c46a4d121688f1fe18d23d35af64a74325255a4dbea07f6b18640ca055c54b68');
insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (10, 'Ashli', 'Raymont', 'Miami', 'United States', 'asherland9@jalbum.net', '$2a$12$dqIu.HAqyHJPe0fcHMaj7OxKSvl.9kX.ocBF2vnxUbsxFHO0IDg6C', 'ea9f13c97a277bb3917b63a2a1234b39', '746848aba0c93093bbba9dd75f41e687f1651b5888d06c10a21b65d80005e1ee');
