<?php
        $mysqli = new mysqli("localhost", "root", "1234", "midatabase");
        if ($mysqli->connect_errno) {
            echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        if (!$mysqli->query("DROP PROCEDURE IF EXISTS nueva_relacion") ||
            !$mysqli->query("CREATE PROCEDURE nueva_relacion (IN id_curso INT, IN id_prerequisito INT)
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                IF EXISTS (SELECT id_curso AND id_prerequisito FROM curso) THEN
                    BEGIN
                        IF EXISTS (select * from INFORMATION_SCHEMA.TABLE_CONSTRAINTS where table_schema='midatabase' and constraint_type='FOREIGN KEY') THEN
                        ROLLBACK;
                        ELSE
                            START TRANSACTION;
                            ALTER TABLE `midatabase`.`prereq` 
                            ADD INDEX `prereqid_idx` (`prereqid` ASC) VISIBLE;
                            ALTER TABLE `midatabase`.`prereq` 
                            ADD CONSTRAINT `prereqid`
                              FOREIGN KEY (`prereqid`)
                              REFERENCES `midatabase`.`curso` (`curso_id`)
                              ON DELETE NO ACTION
                              ON UPDATE NO ACTION;
                        END IF;
                    COMMIT;
                    END;
                END IF;
            END;")) {
            echo "Falló la creación del procedimiento almacenado: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$mysqli->query("call nueva_relacion(1, 2) ")) {
            echo "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        var_dump($resultado->fetch_assoc());
    ?>
