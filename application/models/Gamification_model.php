<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gamification_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_leaderboard()
    {
        $this->db->select('e.first_name, e.last_name, SUM(pp.points) as total_points, COUNT(eb.id) as badges_count');
        $this->db->from('employee e');
        $this->db->join('performance_points pp', 'e.em_id = pp.em_id', 'left');
        $this->db->join('employee_badges eb', 'e.em_id = eb.em_id', 'left');
        $this->db->where('e.em_role !=', 'SUPER ADMIN');
        $this->db->group_by('e.em_id');
        $this->db->order_by('total_points', 'DESC');
        $this->db->limit(10); // Top 10 employees
        $query = $this->db->get();
        
        $leaderboard = $query->result_array();
        
        // Add rank to the results
        $ranked_leaderboard = [];
        $rank = 1;
        foreach ($leaderboard as $row) {
            $row['rank'] = $rank++;
            $row['name'] = $row['first_name'] . ' ' . $row['last_name'];
            $row['points'] = $row['total_points'] ?? 0;
            $row['achievements'] = $row['badges_count'] ?? 0;
            unset($row['first_name'], $row['last_name'], $row['total_points'], $row['badges_count']);
            $ranked_leaderboard[] = $row;
        }
        
        return $ranked_leaderboard;
    }

    public function get_badges()
    {
        $this->db->select('badge_name as name, description, icon_class as icon');
        $this->db->from('badges');
        $query = $this->db->get();
        return $query->result_array();
    }
}
