<?php

class Inventario extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('general_model');
		$this->load->model('articulos_model');
		$this->load->model('usuario_model');
		//	$this->load->model('evento_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		if ($this->session->userdata('logged') != TRUE) {
			redirect(base_url() . 'login');
		}
	}

	/* -------------------------------------------Control y manejos de articulos------------------------------------------------- */

	public function index() {
		
		$data['tipos_articulos'] = $this->general_model->get('tipos_articulos');
		$data['gerencias'] = $this->general_model->get('gerencias');
		
		if (($this->session->userdata('grupo_usuario') == 1) or ($this->session->userdata('grupo_usuario') == 2)){
			$data['articulos'] = $this->articulos_model->buscar();
			$data['sedes'] = $this->general_model->get('sedes');
		}
		if ($this->session->userdata('grupo_usuario') == 3){
			$data['articulos'] = $this->articulos_model->buscar(FALSE, FALSE, 1);
			$data['sedes'] = $this->general_model->get('sedes',1);
		}
		if ($this->session->userdata('grupo_usuario') == 4){
			$data['articulos'] = $this->articulos_model->buscar(FALSE, FALSE, 2);
			$data['sedes'] = $this->general_model->get('sedes',2);
		}
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('administrar/articulos', $data);
		$this->load->view('template/footer');
	}

	public function get($id = FALSE) {
		echo json_encode($this->articulos_model->get($id));
	}

	public function eliminar($id) {
		echo $this->articulos_model->eliminar($id);
	}

	public function agregar() {
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('sede', 'Sede', 'trim|required');
		$this->form_validation->set_rules('gerencia', 'Gerencia', 'trim|required');
		$this->form_validation->set_rules('ubicacion', 'Color', 'trim|max_length[50]');
		$this->form_validation->set_rules('catidad_disponible', 'Cantidad Disponible', 'trim');
		if ($this->form_validation->run()) {
			//echo 'bandera 1';
			$nombre = $this->input->post('nombre');
			$sede = $this->input->post('sede');
			$gerencia = $this->input->post('gerencia');
			$ubicacion = $this->input->post('ubicacion');
			$cantidad_disponible = $this->input->post('cantidad_disponible');
			if ($cantidad_disponible == NULL)
				$cantidad_disponible = 0;
			echo $this->articulos_model->agregar($sede, $nombre, $cantidad_disponible, $ubicacion, $gerencia);
		}
		else
			echo '-10';
	}
	
	public function editar() {
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('sede', 'Sede', 'trim|required');
		$this->form_validation->set_rules('gerencia', 'Tipo de Articulo', 'trim|required');
		$this->form_validation->set_rules('ubicacion', 'Ubicacion', 'trim|max_length[50]');
		$this->form_validation->set_rules('catidad_disponible', 'Cantidad Disponible', 'trim');
		if ($this->form_validation->run()) {
			//echo 'bandera 1';
			$id = $this->input->post('id');
			$nombre = $this->input->post('nombre');
			$sede = $this->input->post('sede');
			$gerencia = $this->input->post('gerencia');
			$ubicacion = $this->input->post('ubicacion');
			$cantidad_disponible = $this->input->post('cantidad_disponible');
			if ($cantidad_disponible == NULL)
				$cantidad_disponible = 0;
			echo $this->articulos_model->editar($id , $sede, $nombre, $cantidad_disponible, $ubicacion, $gerencia);
		}
		else
			echo '-10';
	}

	public function buscar() {
		$nombre = $this->input->post('_nombre');
		$sede = $this->input->post('_sede');
		$gerencia = $this->input->post('_gerencia');
		$status = $this->input->post('_status');

		if (($this->session->userdata('grupo_usuario') == 1) or ($this->session->userdata('grupo_usuario') == 2)){
			echo json_encode($this->articulos_model->buscar(NULL, $nombre, $sede, $gerencia, $status));
		}
		if ($this->session->userdata('grupo_usuario') == 3){
			echo json_encode($this->articulos_model->buscar(NULL, $nombre, 1, $gerencia, $status));
		}
		if ($this->session->userdata('grupo_usuario') == 4){
			echo json_encode($this->articulos_model->buscar(NULL, $nombre, 2, $gerencia, $status));
		}
		
	}

	public function xls() {
		$nombre = $this->input->post('_nombre');
		$sede = $this->input->post('_sede');
		$gerencia = $this->input->post('_gerencia');
		$status = $this->input->post('_status');

		$data['articulos'] = $this->articulos_model->buscar(NULL, $nombre, $sede, $gerencia, $status);
		$this->load->view('xls/inventario_xls', $data);
	}

	/* -------------------------------------------------------------Control de Actas de Entrega------------------------------------------------------------ */

	public function getArticulos() {
		$gerencia = $this->input->post('_gerencia');
		echo json_encode($this->articulos_model->buscar(NULL, NULL, NULL, $gerencia, NULL));
	}

	public function agregar_acta() {
		$id_articulo = $this->input->post('_id_articulo');
		$id_acta_entrega = $this->input->post('id');
		$cantidad = $this->input->post('_cantidad');
		if ($this->articulos_model->salida_de_articulo($id_articulo, $cantidad) > 0)
			echo $this->articulos_model->agregar_articulo($id_acta_entrega, $id_articulo, $cantidad);
		else
			echo -10;
	}

	public function eliminar_acta() {
		$id_articulo = $this->input->post('id_articulo');
		$id_acta_entrega = $this->input->post('id');
		echo $this->articulos_model->eliminar_articulo($id_acta_entrega, $id_articulo);
	}

	public function actas_entregas() {
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('administrar/actas_entregas');
		$this->load->view('template/footer');
	}

	public function actas_entregas_nuevo() {
		$data['sedes'] = $this->general_model->get('sedes');
		$data['gerencias'] = $this->general_model->get('gerencias');
		$data['usuarios'] = $this->usuario_model->get();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('administrar/actas_entregas_nuevo', $data);
		$this->load->view('template/footer');
	}

}