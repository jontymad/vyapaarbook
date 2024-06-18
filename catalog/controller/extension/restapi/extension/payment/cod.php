<?php
class ControllerExtensionRestapiExtensionPaymentCod extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');
        
        $this->load->model('checkout/order');

        $data['order_id'] = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $response['payment'] = $data;

        return $response;
	}

	public function confirm() {
		$json = array();

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$data = array(
'data' => isset($this->session->data['payment_method']['code']),
'pay' => $this->session->data['payment_method']['code']
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));


		if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'cod') {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_cod_order_status_id'));
		
			return new Action('extension/restapi/checkout/success');
		}
		
		return new Action('extension/restapi/checkout/failure');
	}
}
