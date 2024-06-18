<?php
class ControllerExtensionModuleMstoreapp extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/mstoreapp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('mstoreapp', $this->request->post);
			$this->model_setting_setting->editSetting('module_mstoreapp_status', $this->request->post);

			/*if(isset($this->request->post['mstoreapp_demo_blocks']) && $this->request->post['mstoreapp_demo_blocks'] != 'no'){

				$this->load->model('extension/mstoreapp/blocks');

				if($this->request->post['mstoreapp_demo_blocks'] == 'basic')
					$this->model_extension_mstoreapp_blocks->basic();

				if($this->request->post['mstoreapp_demo_blocks'] == 'fashion')
					$this->model_extension_mstoreapp_blocks->fashion();

				if($this->request->post['mstoreapp_demo_blocks'] == 'fashion2')
					$this->model_extension_mstoreapp_blocks->fashion2();

				$this->response->redirect($this->url->link('extension/module/mstoreapp_blocks', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			}*/

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			

		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/mstoreapp', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/mstoreapp', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_mstoreapp_status'])) {
			$data['module_mstoreapp_status'] = $this->request->post['module_mstoreapp_status'];
		} else {
			$data['module_mstoreapp_status'] = $this->config->get('module_mstoreapp_status');
		}

		if (isset($this->request->post['mstoreapp_firebase_server_key'])) {
			$data['mstoreapp_firebase_server_key'] = $this->request->post['mstoreapp_firebase_server_key'];
		} else {
			$data['mstoreapp_firebase_server_key'] = $this->config->get('mstoreapp_firebase_server_key');
		}

		if (isset($this->request->post['mstoreapp_firebase_project_id'])) {
			$data['mstoreapp_firebase_project_id'] = $this->request->post['mstoreapp_firebase_project_id'];
		} else {
			$data['mstoreapp_firebase_project_id'] = $this->config->get('mstoreapp_firebase_project_id');
		}

		if (isset($this->request->post['mstoreapp_firebase_web_api_key'])) {
			$data['mstoreapp_firebase_web_api_key'] = $this->request->post['mstoreapp_firebase_web_api_key'];
		} else {
			$data['mstoreapp_firebase_web_api_key'] = $this->config->get('mstoreapp_firebase_web_api_key');
		}

		if (isset($this->request->post['mstoreapp_onesignal_app_id'])) {
			$data['mstoreapp_onesignal_app_id'] = $this->request->post['mstoreapp_onesignal_app_id'];
		} else {
			$data['mstoreapp_onesignal_app_id'] = $this->config->get('mstoreapp_onesignal_app_id');
		}

		/*

		$data['mstoreapp_demo_blocks'] = 'no';

		if (isset($this->request->post['mstoreapp_support_email'])) {
			$data['mstoreapp_support_email'] = $this->request->post['mstoreapp_support_email'];
		} else {
			$data['mstoreapp_support_email'] = $this->config->get('mstoreapp_support_email');
		}

		

		if (isset($this->request->post['mstoreapp_phone'])) {
			$data['mstoreapp_phone'] = $this->request->post['mstoreapp_phone'];
		} else {
			$data['mstoreapp_phone'] = $this->config->get('mstoreapp_phone');
		}

		if (isset($this->request->post['mstoreapp_fb_url'])) {
			$data['mstoreapp_fb_url'] = $this->request->post['mstoreapp_fb_url'];
		} else {
			$data['mstoreapp_fb_url'] = $this->config->get('mstoreapp_fb_url');
		}

		if (isset($this->request->post['mstoreapp_twitter_url'])) {
			$data['mstoreapp_twitter_url'] = $this->request->post['mstoreapp_twitter_url'];
		} else {
			$data['mstoreapp_twitter_url'] = $this->config->get('mstoreapp_twitter_url');
		}

		if (isset($this->request->post['mstoreapp_gp_url'])) {
			$data['mstoreapp_gp_url'] = $this->request->post['mstoreapp_gp_url'];
		} else {
			$data['mstoreapp_gp_url'] = $this->config->get('mstoreapp_gp_url');
		}

		if (isset($this->request->post['mstoreapp_rate_app_ios'])) {
			$data['mstoreapp_rate_app_ios'] = $this->request->post['mstoreapp_rate_app_ios'];
		} else {
			$data['mstoreapp_rate_app_ios'] = $this->config->get('mstoreapp_rate_app_ios');
		}

		if (isset($this->request->post['mstoreapp_rate_app_android'])) {
			$data['mstoreapp_rate_app_android'] = $this->request->post['mstoreapp_rate_app_android'];
		} else {
			$data['mstoreapp_rate_app_android'] = $this->config->get('mstoreapp_rate_app_android');
		}


		//Dimensions IONIC

		if (isset($this->request->post['mstoreapp_themeHeader'])) {
			$data['mstoreapp_themeHeader'] = $this->request->post['mstoreapp_themeHeader'];
		} else {
			$data['mstoreapp_themeHeader'] = $this->config->get('mstoreapp_themeHeader');
		}

		if (isset($this->request->post['mstoreapp_themetabBar'])) {
			$data['mstoreapp_themetabBar'] = $this->request->post['mstoreapp_themetabBar'];
		} else {
			$data['mstoreapp_themetabBar'] = $this->config->get('mstoreapp_themetabBar');
		}

		if (isset($this->request->post['mstoreapp_themeButton'])) {
			$data['mstoreapp_themeButton'] = $this->request->post['mstoreapp_themeButton'];
		} else {
			$data['mstoreapp_themeButton'] = $this->config->get('mstoreapp_themeButton');
		}
		
		if (isset($this->request->post['mstoreapp_imageHeight'])) {
			$data['mstoreapp_imageHeight'] = $this->request->post['mstoreapp_imageHeight'];
		} else {
			$data['mstoreapp_imageHeight'] = $this->config->get('mstoreapp_imageHeight');
		}

		if (isset($this->request->post['mstoreapp_productSliderWidth'])) {
			$data['mstoreapp_productSliderWidth'] = $this->request->post['mstoreapp_productSliderWidth'];
		} else {
			$data['mstoreapp_productSliderWidth'] = $this->config->get('mstoreapp_productSliderWidth');
		}

		if (isset($this->request->post['mstoreapp_productBorderRadius'])) {
			$data['mstoreapp_productBorderRadius'] = $this->request->post['mstoreapp_productBorderRadius'];
		} else {
			$data['mstoreapp_productBorderRadius'] = $this->config->get('mstoreapp_productBorderRadius');
		}

		if (isset($this->request->post['mstoreapp_productPadding'])) {
			$data['mstoreapp_productPadding'] = $this->request->post['mstoreapp_productPadding'];
		} else {
			$data['mstoreapp_productPadding'] = $this->config->get('mstoreapp_productPadding');
		}

		if (isset($this->request->post['mstoreapp_latestPerRow'])) {
			$data['mstoreapp_latestPerRow'] = $this->request->post['mstoreapp_latestPerRow'];
		} else {
			$data['mstoreapp_latestPerRow'] = $this->config->get('mstoreapp_latestPerRow');
		}

		if (isset($this->request->post['mstoreapp_productsPerRow'])) {
			$data['mstoreapp_productsPerRow'] = $this->request->post['mstoreapp_productsPerRow'];
		} else {
			$data['mstoreapp_productsPerRow'] = $this->config->get('mstoreapp_productsPerRow');
		}

		if (isset($this->request->post['mstoreapp_searchPerRow'])) {
			$data['mstoreapp_searchPerRow'] = $this->request->post['mstoreapp_searchPerRow'];
		} else {
			$data['mstoreapp_searchPerRow'] = $this->config->get('mstoreapp_searchPerRow');
		}

		if (isset($this->request->post['mstoreapp_productShadow'])) {
			$data['mstoreapp_productShadow'] = $this->request->post['mstoreapp_productShadow'];
		} else {
			$data['mstoreapp_productShadow'] = $this->config->get('mstoreapp_productShadow');
		}

		if (isset($this->request->post['mstoreapp_ripple_effect'])) {
			$data['mstoreapp_ripple_effect'] = $this->request->post['mstoreapp_ripple_effect'];
		} else {
			$data['mstoreapp_ripple_effect'] = $this->config->get('mstoreapp_ripple_effect');
		} */

		//END of Dimensions IONIC

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/mstoreapp', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mstoreapp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('setting/setting');
		
		$data = array();

		$data['mstoreapp_themeHeader'] = 'background';
		$data['mstoreapp_themetabBar'] = 'background';
		$data['mstoreapp_themeButton'] = 'custom1';

		$data['mstoreapp_imageHeight'] = 100;
		$data['mstoreapp_productSliderWidth'] = 42;
		$data['mstoreapp_productBorderRadius'] = 10;
		$data['mstoreapp_productPadding'] = 5;
		$data['mstoreapp_latestPerRow'] = 2;
		$data['mstoreapp_productsPerRow'] = 2;
		$data['mstoreapp_searchPerRow'] = 2;
		$data['mstoreapp_productShadow'] = 'no-shadow';
		
		$data['mstoreapp_demo_blocks'] = 'no';
		
		$this->model_setting_setting->editSetting('mstoreapp', $data);

	}


	public function save_options() {

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$entityBody = file_get_contents('php://input');

			$this->load->model('setting/setting');
		
			$data = array();

	        if(isset($entityBody) && !empty($entityBody)) {
	            
	            $options = json_decode($entityBody, true);

	            $settings = $this->model_setting_setting->getSetting('dotapp');

    			$settings[$options['option']] = $options['data'];
			
				$this->editSetting('dotapp', $settings);

	        }
			
		}

		$settings = $this->model_setting_setting->getSetting('dotapp');

		$settings['sfd'] = '';
	
		$this->editSetting('dotapp', $settings);

		$data = true;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));

	}

	public function editSetting($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
	}
}