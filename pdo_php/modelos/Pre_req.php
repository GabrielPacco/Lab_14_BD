<?php

if (!defined('CONTROLADOR'))
    exit;

require_once 'Conexion.php';

class Pre_req {

    private $id;
    private $prereqid;

    const TABLA = 'prereq';
    
    public function __construct($prereqid=null, $id =null) {
        $this->prereqid = $prereqid;
       $this->id  = $id;
    }

    public function getId() {
        return $this->id ;
    }

    public function getPrereqid() {
        return $this->prereqid;
    }

    public function setPrereqid($prereqid) {
        $this->prereqid = $prereqid;
    }

    public function guardar() {
        $conexion = new Conexion();
        if ($this->id ) /* Modifica */ {
            $consulta = $conexion->prepare('UPDATE ' . self::TABLA . ' SET prereqid = :prereqid WHERE id  = :id ');
            $consulta->bindParam(':prereqid', $this->prereqid);
            $consulta->bindParam(':id ', $this->id );
            $consulta->execute();
        } else /* Inserta */ {
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA . ' (prereqid) VALUES(:prereqid)');
            $consulta->bindParam(':prereqid', $this->prereqid);
            $consulta->execute();
            $this->id  = $conexion->lastInsertId();
        }
        $conexion = null;
    }
    
    public function eliminar(){
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE id  = :id');
        $consulta->bindParam(':id ', $this->id );
        $consulta->execute();
        $conexion = null;
    }

    public static function buscarPorId($id) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT prereqid FROM ' . self::TABLA . ' WHERE id  = :id ');
        $consulta->bindParam(':id ', $id);
        $consulta->execute();
        $registro = $consulta->fetch();
        $conexion = null;
        if ($registro) {
            return new self($registro['prereqid'], $id);
        } else {
            return false;
        }
    }

    public static function recuperarTodos() {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT id , prereqid FROM ' . self::TABLA . ' ORDER BY prereqid');
        $consulta->execute();
        $registros = $consulta->fetchAll();
        $conexion = null;
        return $registros;
    }

}