<?php
class ModelExtensionMstoreappSetting extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mstoreapp_setting` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `key` varchar(20) NOT NULL UNIQUE,
			  `value` varchar(255) NOT NULL,
			  `status` INT(1) DEFAULT 1,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");

	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mstoreapp_setting`;");
	}

	public function addValue($key, $value, $status) {
	$this->db->query("INSERT INTO `" . DB_PREFIX . "mstoreapp_setting` SET `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "', `status` = '" . (int)$status . "' ON DUPLICATE KEY UPDATE `value` = '" . $this->db->escape($value) . "', `status` = '" . (int)$status . "'");
	}
}
