<?php

	class ProjectsModel extends CI_Model
	{
		public function getProjects()
		{
			$this->load->database();
			$query = $this->db->get('projects')->result_array();
			
			return $query;
		}
	}

?>