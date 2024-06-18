<?php
class ControllerExtensionRestapiCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		//$data['column_left'] = $this->load->controller('Rest/common/column_left');
		//$data['column_right'] = $this->load->controller('Rest/common/column_right');
		//$data['content_top'] = $this->load->controller('restapi/common/content_top');
		//$data['content_bottom'] = $this->load->controller('Rest/common/content_bottom');
		//$data['footer'] = $this->load->controller('Rest/common/footer');
		//$data['header'] = $this->load->controller('restapi/common/header');
		$data['local'] = $this->load->controller('restapi/common/local');


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
}