<?php
class ControllerExtensionRestapiAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('extension/restapi/account/account', '', true);

			return new Action('extension/restapi/account/login');
		}

		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('extension/restapi/common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/restapi/account/account', '', true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['logged_in'] = true;

		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_my_orders'] = $this->language->get('text_my_orders');
		$data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');

		$data['edit'] = $this->url->link('extension/restapi/account/edit', '', true);
		$data['password'] = $this->url->link('extension/restapi/account/password', '', true);
		$data['address'] = $this->url->link('extension/restapi/account/address', '', true);
		
		$files = glob(DIR_APPLICATION . 'controller/extension/credit_card/*.php');
		
		foreach ($files as $file) {
			$code = basename($file, '.php');
			
			if ($this->config->get('payment_' . $code . '_status') && $this->config->get('payment_' . $code . '_card')) {
				$this->load->language('extension/credit_card/' . $code, 'extension');

				$data['credit_cards'][] = array(
					'name' => $this->language->get('extension')->get('heading_title'),
					'href' => $this->url->link('extension/restapi/extension/credit_card/' . $code, '', true)
				);
			}
		}
		
		$data['wishlist'] = $this->url->link('extension/restapi/account/wishlist');
		$data['order'] = $this->url->link('extension/restapi/account/order', '', true);
		$data['download'] = $this->url->link('extension/restapi/account/download', '', true);
		
		if ($this->config->get('total_reward_status')) {
			$data['reward'] = $this->url->link('extension/restapi/account/reward', '', true);
		} else {
			$data['reward'] = '';
		}		
		
		$data['return'] = $this->url->link('extension/restapi/account/return', '', true);
		$data['transaction'] = $this->url->link('extension/restapi/account/transaction', '', true);
		$data['newsletter'] = $this->url->link('extension/restapi/account/newsletter', '', true);
		$data['recurring'] = $this->url->link('extension/restapi/account/recurring', '', true);
		
		$this->load->model('account/customer');
		
		$data['user'] = array();
		if ($this->customer->isLogged()) {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$data['user']['customer_id'] = $this->customer->getId();
			$data['user']['customer_group_id'] = $customer_info['customer_group_id'];
			$data['user']['firstname'] = $customer_info['firstname'];
			$data['user']['lastname'] = $customer_info['lastname'];
			$data['user']['email'] = $customer_info['email'];
			$data['user']['telephone'] = $customer_info['telephone'];
			$data['user']['custom_field'] = json_decode($customer_info['custom_field'], true);
		}
		$affiliate_info = $this->model_account_customer->getAffiliate($this->customer->getId());
		
		if (!$affiliate_info) {	
			$data['affiliate'] = $this->url->link('extension/restapi/account/affiliate/add', '', true);
		} else {
			$data['affiliate'] = $this->url->link('extension/restapi/account/affiliate/edit', '', true);
		}
		
		if ($affiliate_info) {		
			$data['tracking'] = $this->url->link('extension/restapi/account/tracking', '', true);
		} else {
			$data['tracking'] = '';
		}
		
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
		$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
