<?php

/**
 * Description of administracion1
 *
 * @author desarrollo
 */
class General extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('general_model');
		$this->load->library('session');
	if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
	}

	public function index($tabla='invalido ')
	{
		//$tabla='grupos_usuarios';
		if (!$this->general_model->_validar($tabla))
		{
			show_404();
			return;
		}
		$data["lista"] = $this->general_model->get($tabla);
		$data["tb"] = $tabla;
		$data["titulo_form"] = $this->general_model->get_titulo($tabla);
		$data["titulo_singular_form"] = $this->general_model->get_titulo_singular($tabla);
		$this->load->view('template/header');
		 $this->load->view('template/menu');
		$this->load->view('administrar/general',$data);
		$this->load->view('template/footer');
	}
	
	public function login()
	{
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('login');
		$this->load->view('template/footer');
	}
	
	public function get($tabla,$id=FALSE)
	{
		echo json_encode($this->general_model->get($tabla,$id));
	}
	
	public function eliminar($tabla,$id)
	{
		if (!$this->general_model->_validar($tabla))
		{
			echo -1;
			return;
		}
		echo $this->general_model->eliminar($tabla,$id);
	}
	
	public function agregar($tabla)
	{
		if (!$this->general_model->_validar($tabla))
		{
			echo -1;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');
		if($this->form_validation->run())
		{
			$nombre = $this->input->post('nombre');
			echo $this->general_model->agregar($tabla,$nombre);
		}
		else
			echo '-1';
	}
	
	public function editar($tabla)
	{
		if (!$this->general_model->_validar($tabla))
		{
			echo -1;
			return;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'trim|required|integer');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[100]');
		if($this->form_validation->run())
		{
			$id = $this->input->post('id');
			$nombre = $this->input->post('nombre');
			echo $this->general_model->editar($tabla,$id,$nombre);
		}
		else
			echo '-1';
	}
}

?>
