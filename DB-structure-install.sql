CREATE TABLE profiles(
   profile_id INT AUTO_INCREMENT,
   name VARCHAR(127),
   PRIMARY KEY(profile_id)
);

CREATE TABLE workers(
   worker_id INT AUTO_INCREMENT,
   name VARCHAR(127),
   birth_name VARCHAR(127),
   first_name VARCHAR(127),
   pro_email VARCHAR(127),
   phone_number VARCHAR(20),
   PRIMARY KEY(worker_id)
);

CREATE TABLE formation_tracks(
   formtrack_id INT AUTO_INCREMENT,
   name VARCHAR(127),
   gaia_code VARCHAR(20),
   PRIMARY KEY(formtrack_id)
);

CREATE TABLE formation_bricks(
   brick_id INT AUTO_INCREMENT,
   name VARCHAR(127),
   content_description VARCHAR(500),
   PRIMARY KEY(brick_id)
);

CREATE TABLE sessions(
   session_id INT AUTO_INCREMENT,
   session_date DATE,
   fk_brick_id INT NOT NULL,
   PRIMARY KEY(session_id),
   FOREIGN KEY(fk_brick_id) REFERENCES formation_bricks(brick_id)
);

CREATE TABLE types_of_positions(
   type_of_position_id INT AUTO_INCREMENT,
   label VARCHAR(50),
   PRIMARY KEY(type_of_position_id)
);

CREATE TABLE areas(
   areas_id INT AUTO_INCREMENT,
   label VARCHAR(32),
   PRIMARY KEY(areas_id)
);

CREATE TABLE levels(
   level_id INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(level_id)
);

CREATE TABLE specialities(
   speciality_id INT AUTO_INCREMENT,
   label VARCHAR(50),
   diploma_label VARCHAR(50),
   PRIMARY KEY(speciality_id)
);

CREATE TABLE EDM_file_types(
   EDM_file_type_id INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(EDM_file_type_id)
);

CREATE TABLE EDM_file_states(
   EDM_file_state_id INT AUTO_INCREMENT,
   name VARCHAR(50),
   PRIMARY KEY(EDM_file_state_id)
);

CREATE TABLE users(
   user_id INT AUTO_INCREMENT,
   login VARCHAR(127),
   email VARCHAR(128),
   passwd VARCHAR(255),
   profil_type SMALLINT,
   fk_profile_id INT NOT NULL,
   fk_worker_id INT,
   PRIMARY KEY(user_id),
   FOREIGN KEY(fk_profile_id) REFERENCES profiles(profile_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id)
);

CREATE TABLE schools(
   UAI VARCHAR(8),
   name VARCHAR(50),
   address VARCHAR(127),
   city VARCHAR(50),
   zip_code VARCHAR(6),
   uai_email_address VARCHAR(127),
   name_email_address VARCHAR(127),
   fk_areas_id INT NOT NULL,
   PRIMARY KEY(UAI),
   FOREIGN KEY(fk_areas_id) REFERENCES areas(areas_id)
);

CREATE TABLE classes(
   class_id INT AUTO_INCREMENT,
   period VARCHAR(4) NOT NULL,
   level VARCHAR(25) NOT NULL,
   fk_UAI VARCHAR(8) NOT NULL,
   PRIMARY KEY(class_id),
   FOREIGN KEY(fk_UAI) REFERENCES schools(UAI)
);

CREATE TABLE positions(
   position_id INT AUTO_INCREMENT,
   gaia_id SMALLINT,
   fk_type_of_position_id INT NOT NULL,
   PRIMARY KEY(position_id),
   FOREIGN KEY(fk_type_of_position_id) REFERENCES types_of_positions(type_of_position_id)
);

CREATE TABLE EDM_files(
   EDM_file_id INT AUTO_INCREMENT,
   original_name VARCHAR(255),
   uri VARCHAR(255),
   fk_user_id INT NOT NULL,
   fk_EDM_file_type_id INT,
   PRIMARY KEY(EDM_file_id),
   FOREIGN KEY(fk_user_id) REFERENCES users(user_id),
   FOREIGN KEY(fk_EDM_file_type_id) REFERENCES EDM_file_types(EDM_file_type_id)
);

CREATE TABLE formbricks_belong_to_formtracks(
   fk_formtrack_id INT,
   fk_brick_id INT,
   PRIMARY KEY(fk_formtrack_id, fk_brick_id),
   FOREIGN KEY(fk_formtrack_id) REFERENCES formation_tracks(formtrack_id),
   FOREIGN KEY(fk_brick_id) REFERENCES formation_bricks(brick_id)
);

CREATE TABLE workers_follow_sessions(
   fk_worker_id INT,
   fk_session_id INT,
   PRIMARY KEY(fk_worker_id, fk_session_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id),
   FOREIGN KEY(fk_session_id) REFERENCES sessions(session_id)
);

CREATE TABLE workers_lead_sessions(
   fk_worker_id INT,
   fk_session_id INT,
   PRIMARY KEY(fk_worker_id, fk_session_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id),
   FOREIGN KEY(fk_session_id) REFERENCES sessions(session_id)
);

CREATE TABLE workers_teach_in_classes(
   fk_worker_id INT,
   fk_class_id INT,
   monday_am TINYINT,
   monday_pm TINYINT,
   tuesday_am TINYINT,
   tuesday_pm TINYINT,
   wednesday_am TINYINT,
   thursday_am TINYINT,
   thursday_pm TINYINT,
   friday_am TINYINT,
   friday_pm TINYINT,
   saturday_am TINYINT,
   PRIMARY KEY(fk_worker_id, fk_class_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id),
   FOREIGN KEY(fk_class_id) REFERENCES classes(class_id)
);

CREATE TABLE workers_occupy_positions(
   fk_worker_id INT,
   fk_position_id INT,
   period VARCHAR(4),
   temporary BOOLEAN,
   PRIMARY KEY(fk_worker_id, fk_position_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id),
   FOREIGN KEY(fk_position_id) REFERENCES positions(position_id)
);

CREATE TABLE positions_concern_areas(
   fk_position_id INT,
   fk_areas_id INT,
   PRIMARY KEY(fk_position_id, fk_areas_id),
   FOREIGN KEY(fk_position_id) REFERENCES positions(position_id),
   FOREIGN KEY(fk_areas_id) REFERENCES areas(areas_id)
);

CREATE TABLE levels_concern_classes(
   fk_class_id INT,
   fk_level_id INT,
   headcount TINYINT,
   PRIMARY KEY(fk_class_id, fk_level_id),
   FOREIGN KEY(fk_class_id) REFERENCES classes(class_id),
   FOREIGN KEY(fk_level_id) REFERENCES levels(level_id)
);

CREATE TABLE positions_concern_schools(
   fk_UAI VARCHAR(8),
   fk_position_id INT,
   PRIMARY KEY(fk_UAI, fk_position_id),
   FOREIGN KEY(fk_UAI) REFERENCES schools(UAI),
   FOREIGN KEY(fk_position_id) REFERENCES positions(position_id)
);

CREATE TABLE workers_have_specialities(
   fk_worker_id INT,
   fk_speciality_id INT,
   PRIMARY KEY(fk_worker_id, fk_speciality_id),
   FOREIGN KEY(fk_worker_id) REFERENCES workers(worker_id),
   FOREIGN KEY(fk_speciality_id) REFERENCES specialities(speciality_id)
);

CREATE TABLE EDM_files_have_states(
   fk_user_id INT,
   fk_EDM_file_id INT,
   fk_EDM_file_state_id INT,
   setting_date DATETIME,
   PRIMARY KEY(fk_user_id, fk_EDM_file_id, fk_EDM_file_state_id),
   FOREIGN KEY(fk_user_id) REFERENCES users(user_id),
   FOREIGN KEY(fk_EDM_file_id) REFERENCES EDM_files(EDM_file_id),
   FOREIGN KEY(fk_EDM_file_state_id) REFERENCES EDM_file_states(EDM_file_state_id)
);
