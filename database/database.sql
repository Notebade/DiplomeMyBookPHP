CREATE TABLE author_practics (
                                 id integer NOT NULL,
                                 user_id integer NOT NULL,
                                 practics_id integer NOT NULL,
                                 PRIMARY KEY (id)
);

CREATE TABLE author_test (
                             id integer NOT NULL,
                             user_id integer NOT NULL,
                             test_id integer NOT NULL,
                             PRIMARY KEY (id)
);

CREATE TABLE discipline_subjects (
                                     id integer NOT NULL,
                                     discipline_id integer NOT NULL,
                                     subject_id integer NOT NULL,
                                     PRIMARY KEY (id)
);

CREATE TABLE media_discipline (
                                  id integer NOT NULL,
                                  media_file_id varchar(255) NOT NULL,
                                  media_type_id integer NOT NULL,
                                  direction_id integer NOT NULL,
                                  PRIMARY KEY (id)
);

CREATE TABLE media_text (
                            id integer NOT NULL,
                            position integer NOT NULL,
                            text_id integer NOT NULL,
                            media_file_id integer NOT NULL,
                            PRIMARY KEY (id)
);

CREATE TABLE question_media (
                                id integer NOT NULL,
                                media_file_id integer NOT NULL,
                                question_id integer NOT NULL,
                                PRIMARY KEY (id)
);

CREATE TABLE user_answer (
                             id integer NOT NULL,
                             user_test_id integer NOT NULL,
                             answer_id integer NOT NULL,
                             PRIMARY KEY (id)
);

CREATE TABLE user_group (
                            id integer NOT NULL,
                            user_id integer NOT NULL,
                            group_id integer NOT NULL,
                            PRIMARY KEY (id)
);

CREATE TABLE user_ryght (
                            id integer NOT NULL,
                            user_id integer NOT NULL,
                            right_id integer NOT NULL,
                            PRIMARY KEY (id)
);

CREATE TABLE user_task_media (
                                 id integer NOT NULL,
                                 media_file integer NOT NULL,
                                 user_task_id integer NOT NULL,
                                 PRIMARY KEY (id)
);

CREATE TABLE answers (
                         id integer NOT NULL,
                         questions_id integer NOT NULL,
                         text varchar(255) NOT NULL,
                         right boolean NOT NULL,
                         PRIMARY KEY (id),
                         CONSTRAINT answers_id_user_answer_answer_id_foreign FOREIGN KEY (id) REFERENCES user_answer (answer_id)
);

CREATE TABLE discipline (
                            id integer NOT NULL,
                            code varchar(255) NOT NULL,
                            discription text NOT NULL,
                            date_create timestamp NOT NULL,
                            date_change timestamp NOT NULL,
                            PRIMARY KEY (id),
                            CONSTRAINT direction_id_media_direction_id_foreign FOREIGN KEY (id) REFERENCES media_discipline (direction_id),
                            CONSTRAINT discipline_id_discipline_subjects_discipline_id_foreign FOREIGN KEY (id) REFERENCES discipline_subjects (discipline_id)
);

CREATE TABLE groups (
                        id integer NOT NULL,
                        code varchar(255) NOT NULL,
                        name varchar(255) NOT NULL,
                        PRIMARY KEY (id),
                        CONSTRAINT groups_id_user_group_group_id_foreign FOREIGN KEY (id) REFERENCES user_group (group_id)
);

CREATE TABLE media_files (
                             id integer NOT NULL,
                             user_id integer NOT NULL,
                             type text NOT NULL,
                             patch integer NOT NULL,
                             create_date timestamp NOT NULL,
                             parent_id integer NOT NULL,
                             PRIMARY KEY (id),
                             CONSTRAINT media_files_id_media_files_parent_id_foreign FOREIGN KEY (id) REFERENCES media_files (parent_id),
                             CONSTRAINT media_files_id_question_media_media_file_id_foreign FOREIGN KEY (id) REFERENCES question_media (media_file_id),
                             CONSTRAINT media_files_id_media_text_media_file_id_foreign FOREIGN KEY (id) REFERENCES media_text (media_file_id),
                             CONSTRAINT media_files_id_media_discipline_media_file_id_foreign FOREIGN KEY (id) REFERENCES media_discipline (media_file_id),
                             CONSTRAINT media_files_id_response_media_file_foreign FOREIGN KEY (id) REFERENCES user_task_media (media_file)
);

CREATE TABLE media_types (
                             id integer NOT NULL,
                             code varchar(255) NOT NULL,
                             name varchar(255) NOT NULL,
                             PRIMARY KEY (id),
                             CONSTRAINT media_types_id_media_direction_media_type_foreign FOREIGN KEY (id) REFERENCES media_discipline (media_type_id)
);
COMMENT ON TABLE media_types IS 'Таблица отвечаящая за типы
такие как обложна
пример материала
авторы';

CREATE TABLE rights (
                        id integer NOT NULL,
                        code varchar(255) NOT NULL,
                        name varchar(255) NOT NULL,
                        PRIMARY KEY (id),
                        CONSTRAINT rights_id_user_ryght_column_3_foreign FOREIGN KEY (id) REFERENCES user_ryght (right_id)
);

CREATE TABLE text (
                      id integer NOT NULL,
                      position integer NOT NULL,
                      header_id integer NOT NULL,
                      text text NOT NULL,
                      PRIMARY KEY (id),
                      CONSTRAINT text_id_media_text_text_id_foreign FOREIGN KEY (id) REFERENCES media_text (text_id)
);

CREATE TABLE user_task (
                           id integer NOT NULL,
                           user_id integer NOT NULL,
                           task_id integer NOT NULL,
                           score float NOT NULL,
                           trail integer NOT NULL,
                           PRIMARY KEY (id),
                           CONSTRAINT user_task_id_user_task_media_user_task_id_foreign FOREIGN KEY (id) REFERENCES user_task_media (user_task_id)
);

CREATE TABLE user_test (
                           id integer NOT NULL,
                           test_id integer NOT NULL,
                           user_id integer NOT NULL,
                           score integer NOT NULL,
                           trail integer NOT NULL,
                           PRIMARY KEY (id),
                           CONSTRAINT user_test_id_user_answer_user_test_id_foreign FOREIGN KEY (id) REFERENCES user_answer (user_test_id)
);

CREATE TABLE questions (
                           id integer NOT NULL,
                           text varchar(255) NOT NULL,
                           type_id integer NOT NULL,
                           test_id integer NOT NULL,
                           PRIMARY KEY (id),
                           CONSTRAINT questions_id_question_media_question_id_foreign FOREIGN KEY (id) REFERENCES question_media (question_id),
                           CONSTRAINT questions_id_answers_questions_id_foreign FOREIGN KEY (id) REFERENCES answers (questions_id)
);

CREATE TABLE tasks (
                       id integer NOT NULL,
                       prectic_id integer NOT NULL,
                       text varchar(255) NOT NULL,
                       trail integer NOT NULL,
                       PRIMARY KEY (id),
                       CONSTRAINT tasks_id_user_task_task_id_foreign FOREIGN KEY (id) REFERENCES user_task (task_id)
);

CREATE TABLE users (
                       id integer NOT NULL,
                       login varchar(255) NOT NULL,
                       first_name varchar(255) NOT NULL,
                       last_name varchar(255) NOT NULL,
                       middle_name varchar(255) NOT NULL,
                       email varchar(255) NOT NULL,
                       password varchar(255) NOT NULL,
                       token varchar(255) NOT NULL,
                       CONSTRAINT id PRIMARY KEY (id),
                       CONSTRAINT users_id_user_ryght_user_id_foreign FOREIGN KEY (id) REFERENCES user_ryght (user_id),
                       CONSTRAINT users_id_user_group_user_id_foreign FOREIGN KEY (id) REFERENCES user_group (user_id),
                       CONSTRAINT users_id_user_task_user_id_foreign FOREIGN KEY (id) REFERENCES user_task (user_id),
                       CONSTRAINT users_id_author_practics_user_id_foreign FOREIGN KEY (id) REFERENCES author_practics (user_id),
                       CONSTRAINT users_id_user_test_user_id_foreign FOREIGN KEY (id) REFERENCES user_test (user_id),
                       CONSTRAINT users_id_author_test_user_id_foreign FOREIGN KEY (id) REFERENCES author_test (user_id)
);

CREATE TABLE practics (
                          id integer NOT NULL,
                          header_id integer NOT NULL,
                          code varchar(255) NOT NULL,
                          name varchar(255) NOT NULL,
                          PRIMARY KEY (id),
                          CONSTRAINT practic_id_task_prectic_id_foreign FOREIGN KEY (id) REFERENCES tasks (prectic_id),
                          CONSTRAINT practics_id_author_practics_practics_id_foreign FOREIGN KEY (id) REFERENCES author_practics (practics_id)
);

CREATE TABLE question_type (
                               id integer NOT NULL,
                               code varchar(255) NOT NULL,
                               name varchar(255) NOT NULL,
                               PRIMARY KEY (id),
                               CONSTRAINT question_type_id_questions_type_id_foreign FOREIGN KEY (id) REFERENCES questions (type_id)
);

CREATE TABLE test (
                      id integer NOT NULL,
                      theme_id integer NOT NULL,
                      code varchar(255) NOT NULL,
                      name varchar(255) NOT NULL,
                      trail integer NOT NULL,
                      PRIMARY KEY (id),
                      CONSTRAINT test_id_questions_test_id_foreign FOREIGN KEY (id) REFERENCES questions (test_id),
                      CONSTRAINT test_id_user_test_test_id_foreign FOREIGN KEY (id) REFERENCES user_test (test_id),
                      CONSTRAINT test_id_author_test_test_id_foreign FOREIGN KEY (id) REFERENCES author_test (test_id)
);

CREATE TABLE headers (
                         id integer NOT NULL,
                         code varchar(255) NOT NULL,
                         name integer NOT NULL,
                         theme_id integer NOT NULL,
                         PRIMARY KEY (id),
                         CONSTRAINT headers_id_text_header_id_foreign FOREIGN KEY (id) REFERENCES text (header_id),
                         CONSTRAINT headers_id_practic_header_id_foreign FOREIGN KEY (id) REFERENCES practics (header_id)
);

CREATE TABLE theme (
                       id integer NOT NULL,
                       code varchar(255) NOT NULL,
                       name varchar(255) NOT NULL,
                       subject_id integer NOT NULL,
                       PRIMARY KEY (id),
                       CONSTRAINT theme_id_headers_theme_id_foreign FOREIGN KEY (id) REFERENCES headers (theme_id),
                       CONSTRAINT theme_id_test_theme_id_foreign FOREIGN KEY (id) REFERENCES test (theme_id)
);

CREATE TABLE subject (
                         id integer NOT NULL,
                         code integer NOT NULL,
                         name integer NOT NULL,
                         discription integer NOT NULL,
                         PRIMARY KEY (id),
                         CONSTRAINT subject_id_theme_subject_id_foreign FOREIGN KEY (id) REFERENCES theme (subject_id),
                         CONSTRAINT subject_id_discipline_subjects_subject_id_foreign FOREIGN KEY (id) REFERENCES discipline_subjects (subject_id)
);
