<?php

/**
 * Description of administracion_general1
 *
 * @author desarrollo
 * 

 */
class Actas_entregas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/* --------------------------------------------------------Validaciones----------------------------------------------------------------------- */

	private function _validar($tabla, $id) {
		$sql = 'select count(*) as total from ' . $tabla . ' where id =' . (int) $id;
		$consulta = $this->db->query($sql);
		if ($consulta->row()->total > 0)
			return true;
		else {
			//echo 'bandera validacion '.$tabla.' +'.$id;
			return false;
		}
	}

	private function _validar_usuario($cedula_usuario) {
		$cedula_usuario = $this->db->escape($cedula_usuario);
		$sql = 'select count(*) as total from usuarios where cedula = ' . $cedula_usuario;
		$consulta = $this->db->query($sql);
		if ($consulta->row()->total > 0)
			return true;
		else {
			//echo 'bandera validacion '.$tabla.' +'.$id;
			return false;
		}
	}

	/* --------------------------------------------------------Funciones matriz-------------------------------------------------------- */

	public function agregar($fecha_entrega, $entregado_a, $nota, $id_gerencia, $id_sede, $cedula_usuario) {
		if ((!$this->_validar('sedes', $id_sede)) OR (!$this->_validar('gerencias', $id_gerencia)) OR (!$this->_validar_usuario($cedula_usuario)))
			return -1;

		$fecha_entrega = $this->db->escape($fecha_entrega);
		$entregado_a = $this->db->escape($entregado_a);
		$nota = $this->db->escape($nota);
		$cedula_usuario = $this->db->escape($cedula_usuario);

		//insertamos el elemento en la tabla y retornamos el id con el que se agrego
		$sql = 'insert into actas_entregas (fecha_entrega ,entregado_a, nota, id_gerencia, id_sede, cedula_usuario)' .
						' values (' . $fecha_entrega . ',' . $entregado_a . ',' . $nota . ',' . $id_gerencia . ',' . $id_sede . ', ' . $cedula_usuario . ')';
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			$sql = 'SELECT LASTVAL() as id';
			$query = $this->db->query($sql);
			return $query->row()->id;
		}
		else
			return -1;
	}

	public function editar($id, $fecha_entrega, $entregado_a, $nota, $id_gerencia, $id_sede, $cedula_usuario) {
		if ((!$this->_validar('sedes', $id_sede)) OR (!$this->_validar('gerencias', $id_gerencia)) OR (!$this->_validar_usuario($cedula_usuario)))
			return -1;

		$fecha_entrega = $this->db->escape($fecha_entrega);
		$entregado_a = $this->db->escape($entregado_a);
		$nota = $this->db->escape($nota);
		$cedula_usuario = $this->db->escape($cedula_usuario);


		//Editamos el elemento en la tabla
		$sql = 'update actas_entregas set ' .
						'fecha_servicio = ' . $fecha_entrega . ', ' .
						'realizado_a = ' . $entregado_a . ', ' .
						'detalle_servicio = ' . $nota . ', ' .
						'id_gerencia = ' . $id_gerencia . ', ' .
						'id_sede = ' . $id_sede .
						'cedula_usuario = ' . $cedula_usuario .
						' where id = ' . $id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function eliminar($id) {
		//Eliminamos el elemento de la tabla
		$sql = 'delete from actas_entregas where id = ' . $id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function get($id) {
		$this->db->query('SET datestyle TO postgres, dmy;');
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select *  from data_actas_entregas where id=' . $id;
		$consulta = $this->db->query($sql);
		return $consulta->row();
	}

	public function ultimo() {
		$this->db->query('SET datestyle TO postgres, dmy;');
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select  max(id) as maximo  from data_actas_entregas';
		$consulta = $this->db->query($sql);
		$var = $consulta->row()->maximo;
		return $var;
	}

	/* ---------------------------------------------------------------------Busqueda filtrada------------------------------------------------------------------- */

	public function buscar($id = FALSE, $id_sede = FALSE, $id_gerencia = FALSE, $fecha_inicio = FALSE, $fecha_final = FALSE) {
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select *  from data_actas_entregas where id > 0 ';
		if ($id == FALSE && $id_sede == FALSE && $id_gerencia == FALSE && $fecha_inicio == FALSE && $fecha_final == FALSE) {
			$sql = $sql . ' order by id desc';
			$consulta = $this->db->query($sql);
			return $consulta->result();
		}
		if ($id != NULL) {
			$sql = $sql . ' and  id = ' . $id;
		}

		if ($id_sede != NULL) {
			$sql = $sql . ' and  id_sede = ' . $id_sede;
		}

		if ($id_gerencia != NULL) {
			$sql = $sql . ' and  id_gerencia = ' . $id_gerencia;
		}

		if ($fecha_inicio != FALSE) {
			$fecha_inicio = $this->db->escape($fecha_inicio);
			$sql = $sql . ' and  fecha_entrega >= ' . $fecha_inicio;
		}

		if ($fecha_final != FALSE) {
			$fecha_final = $this->db->escape($fecha_final);
			$sql = $sql . ' and  fecha_entrega <= ' . $fecha_final;
		}

		//echo $sql.'<br/>';
		$sql = $sql . ' order by id desc';
		$consulta = $this->db->query($sql);
		return $consulta->result();
	}

	/* ----------------------------------------------Funciones especificas para el  manejo de tabla actas_entregas--------------------------------------------------------------- */

	public function ver_articulos($id_acta_entrega) {
		$sql = 'select *  from data_detalles_actas_entregas where id_acta_entrega=' . $id_acta_entrega;
		$consulta = $this->db->query($sql);
		return $consulta->result();
	}

}

?>
