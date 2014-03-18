<?php

/**
 * Description of administracion_general1
 *
 * @author desarrollo
 */
class General_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->lista = array('sedes','status_actividades','status_usuarios','cargos',
						'gerencias','grupos_usuarios','tipos_articulos');

		$this->lista_titulos = array("sedes"=>'Sedes',"status_actividades"=>'Status de Actividades',
				"status_usuarios"=>'Status de Usuarios',"cargos"=>'Cargos',
				"gerencias"=>'Gerencias',"grupos_usuarios"=>'Grupos de Usuarios' ,"tipos_articulos"=>'Tipos de Articulos');

		$this->lista_titulos_singular = array("sedes"=>'Sede',"status_actividades"=>'Status de Actividad',
				"status_usuarios"=>'Status de Usuario',"cargos"=>'Cargo',
				"gerencias"=>'Gerencia',"grupos_usuarios"=>'Grupo de Usuario' ,"tipos_articulos"=>'Tipo de Articulo');
	}
	
	public function _validar($tabla)
	{
		foreach ($this->lista as $elemento)
		{
			if ($elemento == $tabla)
				return true;
		}
		return false;
	}
	
	public function agregar($tabla,$nombre)
	{
		if(!$this->_validar($tabla))
			return false;
		$nombre = $this->db->escape($nombre);

		//validamos que no exista otro elemento con el mismo nombre antes de agregarla
		$sql = 'select count(*) as total from '.$tabla.' where lower(nombre) = lower('.$nombre.')';
		$query = $this->db->query($sql);
		if ($query->row()->total >0)
			return -2;
		
		//insertamos el elemento en la tabla y retornamos el id con el que se agrego
		$sql = 'insert into '.$tabla.' (nombre) values('.$nombre.')';
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0)
		{
			$sql = 'SELECT LASTVAL() as id';
			$query = $this->db->query($sql);
			return $query->row()->id;
		}
		return 0;
	}

	public function editar($tabla,$id,$nombre)
	{
		if(!$this->_validar($tabla))
			return false;
		$nombre = $this->db->escape($nombre);

		//validamos que no exista otra elemento con el mismo  nombre antes de editar
		$sql = 'select count(*) as total from '.$tabla.' where lower(nombre) = lower('.$nombre.') and id <>'.(int)$id;
		$query = $this->db->query($sql);
		if ($query->row()->total >0)
			return -2;
		
		//Editamos el elemento en la tabla
		$sql = 'update '.$tabla.' set nombre = '.$nombre.' where id = '.(int)$id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function eliminar($tabla,$id)
	{
		if(!$this->_validar($tabla))
			return false;
		
		//Eliminamos el elemento de la tabla
		$sql = 'delete from '.$tabla.' where id = '.(int)$id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function get($tabla, $id=FALSE)
	{
		if(!$this->_validar($tabla))
			return false;	
		
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select * from '.$tabla;
		if($id==FALSE)
		{
			$sql = $sql.' order by id';
			$consulta = $this->db->query($sql);
			return $consulta->result(); 
		}
		else
		{
			$sql = $sql.' where id = '.(int)$id;
			$consulta = $this->db->query($sql);
			return $consulta->row();
		}
	}
	
	public function get_titulo($tabla)
	{
		if(!$this->_validar($tabla))
			return false;
		return $this->lista_titulos[$tabla];
	}

	public function get_titulo_singular($tabla)
	{
		if(!$this->_validar($tabla))
			return false;
		return $this->lista_titulos_singular[$tabla];
	}

}
?>
