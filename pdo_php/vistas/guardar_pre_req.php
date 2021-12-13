<?php if (!defined('CONTROLADOR')) exit; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title> Guardar Curso Prerequisito </title>
    </head>
    <body>
        <h1> Guardar Curso Prerequisito </h1>
        <form method="post" action="guardar_pre_req.php">
            <label for="prereqid"> Prereqid </label>
            <br />
            <input type="int" name="prereqid" id="prereqid" value="<?php echo $pre_req->getPrereqid() ?>" required />
            <br />
            <?php if ($pre_req->getId()): ?>
                <input type="hidden" name="id" value="<?php echo $pre_req->getId() ?>" />
            <?php endif; ?>
            <input type="submit" value="Guardar" />
            <a href="index.php"> Cancelar </a>
        </form>
    </body>
</html>