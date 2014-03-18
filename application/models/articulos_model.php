<?php

/**
 * Description of administracion_general1
 *
 * @author desarrollo
 * 
 
 */
class Articulos_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

/*--------------------------------------------------------Validaciones-----------------------------------------------------------------------*/
	private function _validar($tabla, $id)
	{
		$sql = 'select count(*) as total from '.$tabla.' where id ='.(int)$id;
		$consulta = $this->db->query($sql);
		if($consulta->row()->total > 0) 
			return true;
		else
		{
			//echo 'bandera validacion '.$tabla.' +'.$id;
			return false;
		}
	}
	
	private function _validar_cantidad($cantidad_disponible)
	{
		if(($cantidad_disponible < 0) ) 
		{
			return false;
		}
			
		else
			return true;			
	}
	
	private function _validar_existencia($nombre, $id_sede, $id_gerencia)
	{
		$sql = 'select *  from data_articulos where id > 0 ';
		$sql = $sql.' and  id_gerencia = '.$id_gerencia;
		$sql = $sql.' and  id_sede = '.$id_sede;
		$nombre = strtolower($nombre);
		$nombre = $this->db->escape($nombre);
		$sql = $sql.' and  lower(nombre) = '.$nombre;
		
		$consulta = $this->db->query($sql);
		if($consulta->row()->total > 0) {
			return true;
		}
		else
		{
			return false;
		}
	}
	

/*--------------------------------------------------------Funciones matriz--------------------------------------------------------*/

	public function agregar($id_sede, $nombre, $cantidad_disponible, $ubicacion, $id_gerencia)
	{
		if((!$this->_validar('sedes', $id_sede)) 
					OR (!$this->_validar('gerencias', $id_gerencia)) 
						OR (!$this->_validar_cantidad($cantidad_disponible)))
			return -1;
		
		if($this->_validar_existencia($nombre, $id_sede, $id_gerencia))
			return -2;
		
		$nombre = $this->db->escape($nombre);
		$ubicacion = $this->db->escape($ubicacion);
		
		//insertamos el elemento en la tabla y retornamos el id con el que se agrego
		$sql = 'insert into articulos (id_sede,nombre,cantidad_disponible,ubicacion, id_gerencia) values ('.$id_sede.','.$nombre.','.$cantidad_disponible.','.$ubicacion.','.$id_gerencia.')';
		$this->db->query($sql);
		return $this->db->affected_rows();	
	}

	
	public function editar($id, $id_sede, $nombre, $cantidad_disponible, $ubicacion, $id_gerencia)
	{
		if((!$this->_validar('sedes', $id_sede)) 
					OR (!$this->_validar('gerencias', $id_gerencia)) 
						OR (!$this->_validar_cantidad($cantidad_disponible)))
			return -1;
		
		$nombre = $this->db->escape($nombre);
		$ubicacion = $this->db->escape($ubicacion);
		
		
		//Editamos el elemento en la tabla
		$sql = 'update articulos set '. 
						'id_sede = '.$id_sede.', '.
						'nombre = '.$nombre.', '.
						'cantidad_disponible = '.$cantidad_disponible.', '.
						'ubicacion = '.$ubicacion.', '.
						'id_gerencia = '.$id_gerencia.
						' where id = '.$id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function eliminar($id)
	{
		//Eliminamos el elemento de la tabla
		$sql = 'delete from articulos where id = '.$id;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function get($id)
	{
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select *  from data_articulos where id='.$id;
		$consulta = $this->db->query($sql);
		return $consulta->row();
	}
	
	
	
/*---------------------------------------------------------------------Busqueda filtrada-------------------------------------------------------------------*/
	public function buscar($id=FALSE, $nombre=FALSE,  $id_sede=FALSE, $id_gerencia=FALSE, $estatus=FALSE)
	{
		
		//En dado caso que no exista id se devolvera la tabla completa, caso contrario se devolvera el registro especificado
		$sql = 'select *  from data_articulos where id > 0 ';
		if($id==FALSE && $nombre==FALSE &&  $id_sede==FALSE && $id_gerencia==FALSE && $estatus==FALSE)
		{
			
			$sql = $sql.' order by id_sede, id_gerencia';
			$consulta = $this->db->query($sql);
			return $consulta->result(); 
		}
			if ($id!=NULL)
			{
				$sql = $sql.' and  id = '.$id;
			}
			
			if ($nombre!=NULL)
			{
				$nombre = strtolower($nombre);
				$sql = $sql." and  lower(nombre) like '%".$nombre."%'";
			}
			
			if ($id_sede!=NULL)
			{
				$sql = $sql.' and  id_sede = '.$id_sede;
			}
			
			if ($id_gerencia!=NULL)
			{
				//echo 'bander';
				$sql = $sql.' and  id_gerencia = '.$id_gerencia;
			}
			
			if ($estatus=='A')
			{
				$sql = $sql.' and  cantidad_disponible = 0 ';
			}
			
			//echo $sql.'<br/>';
			$consulta = $this->db->query($sql);
			return $consulta->result(); 
		
	}
	
	
/*----------------------------------------------Funciones especificas para el  manejo de tabla articulos---------------------------------------------------------------*/
	
	//Modifica el valor en base a la salida de articulo
	public function salida_de_articulo ($id, $cantidad_salida)
	{
		$sql ='select cantidad_disponible from articulos where id ='.$id;
		$consulta = $this->db->query($sql);
		$cantidad_disponible = $consulta->row()->cantidad_disponible;
		 
		if($cantidad_salida > $cantidad_disponible)
		{
			return -1;
		}
		
		else
		{
			$sql ='Update articulos set '. 
			' cantidad_disponible = cantidad_disponible-'.$cantidad_salida.
			' where id = '.$id;
			$consulta = $this->db->query($sql);
			return $this->db->affected_rows();
		}
	}
	
	public function entrada_de_articulo ($id, $cantidad_entrada)
	{
		$sql ='Update articulos set '. 
		' cantidad_disponible = cantidad_disponible+'.$cantidad_entrada.
		' where id = '.$id;
		$consulta = $this->db->query($sql);
		return $this->db->affected_rows();
	}
	
/*---------------------------------Funciones acta de entrega--------------------------------*/
	public function agregar_articulo ($id_acta_entrega, $id_articulo, $cantidad)
	{
		if((!$this->_validar('actas_entregas', $id_acta_entrega)) 
				OR (!$this->_validar('articulos', $id_articulo)) )
			return -1;
		
		$sql = 'insert into detalles_actas_entregas '.
				  ' values ('.$id_acta_entrega.','.$id_articulo.','.$cantidad.')';
		$this->db->query($sql);
		return $this->db->affected_rows();	
	}
				
	public function eliminar_articulo ($id_acta_entrega, $id_articulo)
	{
		if((!$this->_validar('actas_entregas', $id_acta_entrega)) 
				OR (!$this->_validar('articulos', $id_articulo)) )
			return -1;
		
		$sql = 'select * from detalles_actas_entregas where id_acta_entrega = '.$id_acta_entrega.' and id_articulo ='. $id_articulo;
		$consulta = $this->db->query($sql);
		$cantidad_entrada = $consulta->row()->cantidad; 
		
		$sql = 'delete from detalles_actas_entregas '.
				  ' where id_acta_entrega = '.$id_acta_entrega.' and id_articulo = '.$id_articulo;
		if($this->db->query($sql))
		{
			entrada_de_articulo ($id_articulo, $cantidad_entrada);
			return $this->db->affected_rows();
		}
		else
			return -1;
	}
	
	public function ver_articulos ($id_acta_entrega)
	{
		$sql = 'select *  from data_detalles_actas_entregas where id_acta_entrega='.$id_acta_entrega;
		$consulta = $this->db->query($sql);
		return $consulta->result(); 
	}
}
?>
