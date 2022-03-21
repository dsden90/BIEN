INSERT INTO `EDM_file_states` (`EDM_file_state_id`, `name`) VALUES (1, 'waiting for approval'), (2, 'waiting for treatment'), (3, 'archive'), (4, 'to delete');

INSERT INTO `EDM_file_types` (`name`) VALUES ('Fiche école'), ('Export Agape'), ('Export Onde'), ('Export Gaïa');

INSERT INTO `profiles` (`profile_id`, `name`) VALUES (NULL, 'admin');

INSERT INTO `users` (`user_id`, `login`, `email`, `passwd`, `fk_profile_id`, `fk_worker_id`) VALUES ('1', 'admin', NULL, 'admin', '1', NULL); 

INSERT INTO `levels` (`level_id`, `name`) VALUES (NULL, 'TPS'), (NULL, 'PS'), (NULL, 'MS'), (NULL, 'GS'), (NULL, 'CP'), (NULL, 'CE1'), (NULL, 'CE2'), (NULL, 'CM1'), (NULL, 'CM2') 