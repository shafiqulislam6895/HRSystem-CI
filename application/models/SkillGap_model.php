<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SkillGap_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_employees_for_analysis()
    {
        $this->db->select('em_id, first_name, last_name, des_name');
        $this->db->from('employee');
        $this->db->join('designation', 'employee.des_id = designation.id', 'left');
        $this->db->where('em_role !=', 'SUPER ADMIN');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_skill_gap_analysis($em_id)
    {
        // 1. Get employee details
        $this->db->select('e.em_id, e.first_name, e.last_name, d.id as des_id, d.des_name');
        $this->db->from('employee e');
        $this->db->join('designation d', 'e.des_id = d.id', 'left');
        $this->db->where('e.em_id', $em_id);
        $employee = $this->db->get()->row_array();

        if (!$employee) {
            return null;
        }

        // 2. Get required skills for the employee's designation
        $this->db->select('s.skill_name, ds.required_level');
        $this->db->from('designation_skills ds');
        $this->db->join('skills s', 'ds.skill_id = s.id');
        $this->db->where('ds.des_id', $employee['des_id']);
        $required_skills_data = $this->db->get()->result_array();
        
        $required_skills = [];
        foreach ($required_skills_data as $rs) {
            $required_skills[$rs['skill_name']] = $rs['required_level'];
        }

        // 3. Get employee's current skills
        $this->db->select('s.skill_name, es.current_level');
        $this->db->from('employee_skills es');
        $this->db->join('skills s', 'es.skill_id = s.id');
        $this->db->where('es.em_id', $em_id);
        $employee_skills_data = $this->db->get()->result_array();

        $employee_skills = [];
        foreach ($employee_skills_data as $es) {
            $employee_skills[$es['skill_name']] = $es['current_level'];
        }

        // 4. Calculate the skill gap and identify training recommendations
        $gap = [];
        $recommendations = [];
        $level_map = ['Basic' => 1, 'Intermediate' => 2, 'Advanced' => 3, 'Expert' => 4];

        foreach ($required_skills as $skill_name => $required_level) {
            $current_level = $employee_skills[$skill_name] ?? 'None';
            
            if (($level_map[$current_level] ?? 0) < $level_map[$required_level]) {
                $gap[] = [
                    'skill' => $skill_name,
                    'required' => $required_level,
                    'current' => $current_level
                ];

                // Get training recommendations for the missing/deficient skill
                $this->db->select('tc.course_name, tc.link');
                $this->db->from('training_courses tc');
                $this->db->join('skills s', 'tc.related_skill_id = s.id');
                $this->db->where('s.skill_name', $skill_name);
                $training = $this->db->get()->result_array();
                
                foreach ($training as $t) {
                    $recommendations[] = $t;
                }
            }
        }

        return [
            'employee' => $employee,
            'required_skills' => $required_skills,
            'employee_skills' => $employee_skills,
            'gap' => $gap,
            'recommendations' => $recommendations
        ];
    }
}
