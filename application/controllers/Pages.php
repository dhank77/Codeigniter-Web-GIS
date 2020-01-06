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
			$marker['infowindow_content'] = "<div class='infoW'><div class='paWrapper'><div style='background-color:#fff;'><table class='table table-striped table-bordered'><tbody><tr><th colspan='6' style='text-align: center'>DETAIL INFORMASI</th></tr><tr><td colspan='2'>Nama Wisata :</td><td colspan='4'>{$d['nama']}</td></tr><tr><td colspan='2'>Jalan :</td><td colspan='4'>{$d['keterangan']}</td></tr></tbody></table></div></div></div>";
			$marker['icon'] = $d['icon'];
			$this->googlemaps->add_marker($marker);
		}
		$data['map'] = $this->googlemaps->create_map();

		$this->load->view('layouts/header', $data);
		$this->load->view('pages/index', $data);
		$this->load->view('layouts/js');
	}
}
