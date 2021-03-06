<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends CI_Controller 
{
	public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        if ($q <> '') {
            $config['base_url'] = base_url() . 'admin/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'admin/index.html?q=' . urlencode($q);

        } else {
            $config['base_url'] = base_url() . 'admin/index.html';
            $config['first_url'] = base_url() . 'admin/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->M_pekerjaan->total_rows($q);
        $pekerjaan = $this->M_pekerjaan->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pekerjaan_data' => $pekerjaan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'admin/listpekerjaan',
            'judul' => 'Data Pekerjaan',
        );
        $this->load->view('index', $data);
    }

	public function read($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);
        if ($row) {
            $data = array(
			'id_pekerjaan' => $row->id_pekerjaan,
			'pekerjaan' => $row->pekerjaan,
			'gapok' => $row->gapok,
			'tukes' => $row->tukes,
			'tutra' => $row->tutra,
			'tupen' => $row->tupen,
			);
            $this->load->view('pekerjaan/pekerjaan_read', $data);
			
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('pekerjaan'));
        }
    }

	public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => base_url('pekerjaan/create_action'),
			'id_pekerjaan' => set_value('id_pekerjaan'),
			'pekerjaan' => set_value('pekerjaan'),
			'gapok' => set_value('gapok'),
			'tukes' => set_value('tukes'),
			'tutra' => set_value('tutra'),
			'tupen' => set_value('tupen'),
			'tukel' => set_value('tukel'),
            'judul' => 'Data Pekerjaan',
            'konten' => 'admin/formpekerjaan',
		);
        $this->load->view('index', $data);
    }

	public function create_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();

        } else {
            $data = array(
			'pekerjaan' => $this->input->post('pekerjaan',TRUE),
			'gapok' => $this->input->post('gapok',TRUE),
			'tukes' => $this->input->post('tukes',TRUE),
			'tutra' => $this->input->post('tutra',TRUE),
			'tupen' => $this->input->post('tupen',TRUE),
			'tukel' => $this->input->post('tukel',TRUE),
			);
            $this->M_pekerjaan->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(base_url('pekerjaan'));
        }
    }

	public function update($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => base_url('pekerjaan/update_action'),
				'id_pekerjaan' => set_value('id_pekerjaan', $row->id_pekerjaan),
				'pekerjaan' => set_value('pekerjaan', $row->pekerjaan),
				'gapok' => set_value('gapok', $row->gapok),
				'tukes' => set_value('tukes', $row->tukes),
				'tutra' => set_value('tutra', $row->tutra),
				'tupen' => set_value('tupen', $row->tupen),
				'tukel' => set_value('tukel', $row->tukel),
				'konten' => 'admin/formpekerjaan',
				'judul' => 'Data Pekerjaan',
			);
            $this->load->view('index', $data);

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('pekerjaan'));
        }
    }

	public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pekerjaan', TRUE));

        } else {
            $data = array(
			'pekerjaan' => $this->input->post('pekerjaan',TRUE),
			'gapok' => $this->input->post('gapok',TRUE),
			'tukes' => $this->input->post('tukes',TRUE),
			'tutra' => $this->input->post('tutra',TRUE),
			'tupen' => $this->input->post('tupen',TRUE),
			'tukel' => $this->input->post('tukel',TRUE),
			);
            $this->M_pekerjaan->update($this->input->post('id_pekerjaan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(base_url('pekerjaan'));
        }
    }

	public function delete($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);
        if ($row) {
            $this->M_pekerjaan->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(base_url('pekerjaan'));

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('pekerjaan'));
        }
    }

	public function _rules() 
    {
		$this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'trim|required');
		$this->form_validation->set_rules('gapok', 'gapok', 'trim|required');
		$this->form_validation->set_rules('tukes', 'tukes', 'trim|required');
		$this->form_validation->set_rules('tutra', 'tutra', 'trim|required');
		$this->form_validation->set_rules('tupen', 'tupen', 'trim|required');
		$this->form_validation->set_rules('id_pekerjaan', 'id_pekerjaan', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
