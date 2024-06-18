<?php
class ControllerExtensionRestapiCommonConfig extends Controller {
	public function index() {
	
		$this->load->model('setting/setting');

		$data['mstoreapp_status'] = $this->model_setting_setting->getSetting('module_mstoreapp_status');
		$data['rate_app_ios'] = $this->model_setting_setting->getSetting('mstoreapp_rate_app_ios');
		$data['rate_app_android'] = $this->model_setting_setting->getSetting('mstoreapp_rate_app_android');
		$data['rate_app_windows'] = $this->model_setting_setting->getSetting('mstoreapp_rate_app_windows');
		$data['share_app'] = $this->model_setting_setting->getSetting('mstoreapp_share_app');
		$data['support_email'] = $this->model_setting_setting->getSetting('mstoreapp_support_email');


		return $data;
		
	}
	
}
