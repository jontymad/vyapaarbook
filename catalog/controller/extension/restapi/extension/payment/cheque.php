<?php
class ControllerExtensionRestapiExtensionPaymentCheque extends Controller {
	public function index() {
		$this->load->language('extension/payment/cheque');

		$data['payable'] = $this->config->get('payment_cheque_payable');
		$data['address'] = nl2br($this->config->get('config_address'));

		return $data;
	}

	public function confirm() {
		$json = array();
		
		if ($this->session->data['payment_method']['code'] == 'cheque') {
			$this->load->language('extension/payment/cheque');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_payable') . "\n";
			$comment .= $this->config->get('payment_cheque_payable') . "\n\n";
			$comment .= $this->language->get('text_address') . "\n";
			$comment .= $this->config->get('config_address') . "\n\n";
			$comment .= $this->language->get('text_payment') . "\n";
			
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_cheque_order_status_id'), $comment, true);
			
			return new Action('extension/restapi/checkout/success');
		}
		
		return new Action('extension/restapi/checkout/failure');
	}
}