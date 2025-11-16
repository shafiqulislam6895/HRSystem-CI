<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SkillGap extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SkillGap_model');
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Skill Gap & Training Recommender';
        $data['employees'] = $this->SkillGap_model->get_employees_for_analysis();
        
        $this->load->view('backend/header', $data);
        $this->load->view('skill_gap/index', $data);
        $this->load->view('backend/footer');
    }

    public function analyze($employee_id)
    {
        $data['title'] = 'Skill Gap Analysis';
        $data['analysis'] = $this->SkillGap_model->get_skill_gap_analysis($employee_id);
        
        $this->load->view('backend/header', $data);
        $this->load->view('skill_gap/analysis', $data);
        $this->load->view('backend/footer');
    }
}