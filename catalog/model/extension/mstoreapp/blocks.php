<?php
class ModelExtensionMstoreappBlocks extends Model {

	public function getBlocks($id) {
		
 		 	$sql = "SELECT 
			id,
                  parent_id,
                  name,
                  block_type,
                  image_url,
                  width,
                  height,
                  link_id,
                  link_type,
                  sort_order,
                  status,
                  margin_top,
                  margin_right,
                  margin_bottom,
                  margin_left,
                  padding_top,
                  padding_right,
                  padding_bottom,
                  padding_left,
                  bg_color,
                  elevation,
                  margin_between,
                  border_radius,
                  layout,
                  layout_grid_col,
                  shape,
                  header_align,
                  text_color,
                  end_time


            FROM " . DB_PREFIX . "mstoreapp_blocks  where status='1' and parent_id = '" . (int)$id . "'";

            $query = $this->db->query($sql);

            return $query->rows;
			
	}

	public function getsubChildren($id) {
 		 
 		 	$sql = "SELECT 
      		id,
                  parent_id,
                  name,
                  parent_id,
                  block_type,
                  image_url,
                  width,
                  height,
                  link_id,
                  link_type,
                  sort_order,
                  status,
                  margin_top,
                  margin_right,
                  margin_bottom,
                  margin_left,
                  padding_top,
                  padding_right,
                  padding_bottom,
                  padding_left,
                  bg_color,
                  elevation,
                  margin_between,
                  border_radius,
                  layout,
                  layout_grid_col,
                  shape,
                  header_align,
                  text_color,
                  end_time 


            FROM " . DB_PREFIX . "mstoreapp_blocks  where status='1' and parent_id = '" . (int)$id . "'";

            $query = $this->db->query($sql);

            return $query->rows;

	}

	public function getAllBlocks() {
		
 		$sql = "SELECT * FROM " . DB_PREFIX . "mstoreapp_blocks";

            $query = $this->db->query($sql);

            return $query->rows;
			
	}


	
}
