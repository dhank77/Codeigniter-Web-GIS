<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

	public function index()
	{
		$this->load->library('googlemaps');

		$config['center'] = '-2.668611, 118.862222';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);

		$data = $this->db->get('marker')->result_array();
		foreach($data as $d){
			$marker = array();
			$marker['position'] = $d['latlong'];
			$marker['infowindow_content'] = $d['keterangan'];
			$marker['icon'] = $d['icon'];
			$this->googlemaps->add_marker($marker);
		}
		$data['map'] = $this->googlemaps->create_map();

		$this->load->view('layouts/header', $data);
		$this->load->view('pages/index', $data);
		$this->load->view('layouts/js');
	}
}
