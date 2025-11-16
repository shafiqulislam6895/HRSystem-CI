<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gamification extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gamification_model');
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Performance & Goal Gamification';
        $data['leaderboard'] = $this->Gamification_model->get_leaderboard();
        $data['badges'] = $this->Gamification_model->get_badges();
        
        $this->load->view('backend/header', $data);
        $this->load->view('gamification/index', $data);
        $this->load->view('backend/footer');
    }
}