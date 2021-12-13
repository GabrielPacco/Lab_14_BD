<?php if (!defined('CONTROLADOR')) exit; ?>

<?php header("Content-type: text/css");

//Creo un array con varios colores
$color[0]='#ff0000';
$color[1]='#00ff00';
$color[2]='#0000ff';

// Elijo un color aleatorio
$i=rand(0,2);
?>

<?php
        $mysqli = new mysqli("localhost", "root", "1234", "midatabase");
        if ($mysqli->connect_errno) {
            echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        if (!$mysqli->query("DROP PROCEDURE IF EXISTS insertar") ||
            !$mysqli->query("CREATE PROCEDURE insertar (IN nombrecurso varchar(45), IN numerocreditos INT, IN id_departamento INT)
            BEGIN
                START TRANSACTION;
                IF EXISTS (SELECT nombre FROM curso WHERE nombrecurso = nombre) THEN
                    BEGIN
                        UPDATE curso
                        SET nombre = nombrecurso,
                            creditos = numerocreditos,
                            depa_id = id_departamento
                        WHERE nombre = nombrecurso;
                    END;
                ELSE
                    INSERT INTO curso(nombre, creditos, depa_id)
                    VALUES (nombrecurso, numerocreditos, id_departamento);
                END IF;
                COMMIT;
            END;")) {
            echo "Falló la creación del procedimiento almacenado: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$mysqli->query("call insertar('AED Avanzadoss', 4, 2); ")) {
            echo "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        var_dump($resultado->fetch_assoc());
    ?>
