<?php
class ControllerExtensionRestapiModuleMstoreapp extends Controller {
	public function index() {


		$this->load->model('extension/mstoreapp/blocks');

		$this->load->model('tool/image');

		if(isset($this->request->get['id'])){
			$id = $this->request->get['id'];
		} else $id = 0;

		$results = array();
			
		$results['blocks'] = $this->model_extension_mstoreapp_blocks->getBlocks($id);

		usort($results['blocks'], function($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });
		/*foreach ($results['blocks'] as $key => $value) {

			if ($results['blocks'][$key]['image_url'] != '' && $results['blocks'][$key]['width'] != 0 && $results['blocks'][$key]['height'] != 0)
			$results['blocks'][$key]['image'] = $this->model_tool_image->resize($results['blocks'][$key]['image_url'], $results['blocks'][$key]['width'], $results['blocks'][$key]['height']);
			$results['blocks'][$key]['children'] = $this->getChildren($value['id']);

		}*/
		foreach ($results['blocks'] as $key => $value) {

			if($results['blocks'][$key]['width'] != 0) {
				$width = $results['blocks'][$key]['width'];
			} else $width = 100;

			if($results['blocks'][$key]['height'] != 0) {
				$height = $results['blocks'][$key]['height'];
			} else $height = 100;

			if ($results['blocks'][$key]['image_url'] != '')
				$results['blocks'][$key]['image'] = $this->model_tool_image->resize($results['blocks'][$key]['image_url'], $width, $height);
				$results['blocks'][$key]['children'] = $this->getChildren($value['id']);
			if($results['blocks'][$key]['block_type'] == 'product_block')
				$results['blocks'][$key]['products'] = $this->get_products($value['link_id']);

		}

		$results['settings'] = $this->get_settings();

		if(isset($results['settings']['mstoreapp_support_email']) && !empty($results['settings']['mstoreapp_support_email'])) {

			$this->load->model('account/customer');

            $customer_info = $this->model_account_customer->getCustomerByEmail($results['settings']['mstoreapp_support_email']);

            if (!empty($customer_info)) {
                $results['settings']['supportUserId'] = $customer_info['customer_id'];
            }

        }

		$results['dimensions'] = array(
			'imageHeight' => $results['settings']['mstoreapp_imageHeight'],
			'productSliderWidth' => $results['settings']['mstoreapp_productSliderWidth'], 
			'latestPerRow' => $results['settings']['mstoreapp_latestPerRow'], 
			'productsPerRow' => $results['settings']['mstoreapp_productsPerRow'], 
			'searchPerRow' => $results['settings']['mstoreapp_searchPerRow'],
			'productBorderRadius' => $results['settings']['mstoreapp_productBorderRadius'],
			'productPadding' => $results['settings']['mstoreapp_productPadding']
		);

		$results['theme'] = array(
			'tabBar' => $results['settings']['mstoreapp_themetabBar'],
			'header' => $results['settings']['mstoreapp_themeHeader'], 
			'button' => $results['settings']['mstoreapp_themeButton']
		);

		$results['categories'] = $this->get_categories();

		$results['products'] = $this->get_products(0);

		$results['local'] = $this->load->controller('extension/restapi/common/local');
		$results['language'] = $this->load->controller('extension/restapi/common/language');
		$results['currency'] = $this->load->controller('extension/restapi/common/currency');
		$results['isLoggedIn'] = $this->customer->isLogged();
		
        $this->load->model('account/customer');

		$results['user'] = (object)array();
		if ($this->customer->isLogged()) {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

			$results['user'] = array(
				'customer_id' => $this->customer->getId(),
				'customer_group_id' => $customer_info['customer_group_id'],
				'firstname' => $customer_info['firstname'],
				'lastname' => $customer_info['lastname'],
				'email' => $customer_info['email'],
				'telephone' => $customer_info['telephone'],
				'custom_field' => json_decode($customer_info['custom_field'], true)
			);

			/*$results['user']['customer_id'] = $this->customer->getId();
			$results['user']['customer_group_id'] = $customer_info['customer_group_id'];
			$results['user']['firstname'] = $customer_info['firstname'];
			$results['user']['lastname'] = $customer_info['lastname'];
			$results['user']['email'] = $customer_info['email'];
			$results['user']['telephone'] = $customer_info['telephone'];
			$results['user']['custom_field'] = json_decode($customer_info['custom_field'], true);*/
		}

		$this->load->model('catalog/information');

		$results['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$results['informations'][] = array(
					'id' => $result['information_id'],
					'title' => $result['title'],
					'href'  => $this->url->link('extension/restapi/information/information/info', 'information_id=' . $result['information_id'])
				);
			}
		}

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($results));

	}

	public function getChildren($id){

		$this->load->model('extension/mstoreapp/blocks');

		$this->load->model('tool/image');
		
		$children_data = $this->model_extension_mstoreapp_blocks->getBlocks($id);

		usort($children_data, function($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });

		if (!empty($children_data)) {
			
			/*foreach ($children_data as $key => $value) {

			if ($children_data[$key]['image_url'] != '' && $children_data[$key]['width'] != 0 && $children_data[$key]['height'] != 0)
			$children_data[$key]['image'] = $this->model_tool_image->resize($children_data[$key]['image_url'], $children_data[$key]['width'], $children_data[$key]['height']);
			$children_data[$key]['children'] = $this->getChildren($value['id']);
			
			}*/

			foreach ($children_data as $key => $value) {

				if($children_data[$key]['width'] != 0) {
					$width = $children_data[$key]['width'];
				} else $width = 100;

				if($children_data[$key]['height'] != 0) {
					$height = $children_data[$key]['height'];
				} else $height = 100;

				if ($children_data[$key]['image_url'] != '')
				$children_data[$key]['image'] = $this->model_tool_image->resize($children_data[$key]['image_url'], $width, $height);
				$children_data[$key]['children'] = $this->getChildren($value['id']);

				if($children_data[$key]['block_type'] == 'product_block' || $children_data[$key]['block_type'] == 'flash_sale') {
					$children_data[$key]['products'] = $this->get_products($children_data[$key]['link_id']);
				}
			}
		}

		return $children_data;
	}

	public function get_categories(){

		$this->load->model('tool/image');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			//$children_data = array();

			if ($category['category_id']) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					if ($child['image']) {
					$image =  $this->model_tool_image->resize($child['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
				    }else $image = '';

					$data[] = array(
						'id' => (int)$child['category_id'],
						'name' => $child['name'],
						'description' => $child['description'],
						'parent' => (int)$child['parent_id'],
						'count' => $this->config->get('config_product_count') ? (int)$this->model_catalog_product->getTotalProducts($filter_data) : 0,
						'image'    => $image,
					);
				}
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			if ($category['image']) {
				$image =  $this->model_tool_image->resize($category['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
			}else $image = '';

			$data[] = array(
				'id' => (int)$category['category_id'],
				'name'        => $category['name'],
				'description' => $category['description'],
				'parent' => (int)$category['parent_id'],
				'count'    => $this->config->get('config_product_count') ? (int)$this->model_catalog_product->getTotalProducts($filter_data) : 0,
				'image'    => $image,
			);
		}

		return $data;

	}

	public function get_settings() {

		$settings = array();

		$this->load->model('setting/setting');
		
		$settings = $this->model_setting_setting->getSetting('mstoreapp');

		return $settings;

	}

	public function blocks(){

		$this->load->model('extension/mstoreapp/blocks');

		$results = $this->model_extension_mstoreapp_blocks->getAllBlocks();

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($results));

	}

	public function get_products($id) {

		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data = array();

		if (isset($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else {
			$page = 1;
		}

		if (isset($_REQUEST['limit'])) {
			$limit = (int)$_REQUEST['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$filter_data = array(
			'filter_category_id' => $id,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				$formatted_price = $this->currency->format($price, $this->session->data['currency']);
			} else {
				$price = '0';
				$formatted_price = null;
			}

			if ((float)$result['special']) {
				$sale_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				$formatted_sales_price = $this->currency->format($sale_price, $this->session->data['currency']);
			} else {
				$sale_price = '0';
				$formatted_sales_price = null;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$options = array();

			foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$option_price = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$option_price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $option_price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$options[] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			$data[] = array(
				'product_id'  => $result['product_id'],
				'images'       => array(
					array(
						'src' => $image
					)
				),
				'name'        => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'formatted_price'       => $formatted_price,
				'formatted_sales_price'     => $formatted_sales_price,
				'price'       => $price,
				'sales_price'     => $sale_price,
				'tax'         => $tax,
				'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'average_rating'      => (String)$result['rating'],
				'options'	  => $options,
			);
		}
		return $data;
	}

	public function getProducts() {

		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data = array();

		if (isset($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else {
			$page = 1;
		}

		if (isset($_REQUEST['id'])) {
			$id = (int)$_REQUEST['id'];
		} else {
			$id = 0;
		}

		if (isset($_REQUEST['limit'])) {
			$limit = (int)$_REQUEST['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$filter_data = array(
			'filter_category_id' => $id,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				$formatted_price = $this->currency->format($price, $this->session->data['currency']);
			} else {
				$price = '0';
				$formatted_price = false;
			}

			if ((float)$result['special']) {
				$sale_price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
				$formatted_sales_price = $this->currency->format($sale_price, $this->session->data['currency']);
			} else {
				$sale_price = '0';
				$formatted_sales_price = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$options = array();

			foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$option_price = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$option_price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $option_price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$options[] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			$data[] = array(
				'product_id'  => $result['product_id'],
				'images'       => array(
					array(
						'src' => $image
					)
				),
				'name'        => $result['name'],
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'formatted_price'       => $formatted_price,
				'formatted_sales_price'     => $formatted_sales_price,
				'price'       => $price,
				'sales_price'     => $sale_price,
				'tax'         => $tax,
				'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'average_rating'      => (String)$result['rating'],
				'options'	  => $options,
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
		$this->response->setOutput(json_encode($data));

	}

	public function dotapp() {

		$results = array();

		$this->load->model('setting/setting');
		
		$results = $this->model_setting_setting->getSetting('dotapp');

		$results['categories'] = $this->get_categories();

		$results['recentProducts'] = $this->get_products(0);

		if(isset($results['dotapp_blocks']) && is_array($results['dotapp_blocks'])) {
			foreach ($results['dotapp_blocks'] as $key => $value) {

				if($results['dotapp_blocks'][$key]['blockType'] == 'productList' || $results['dotapp_blocks'][$key]['blockType'] == 'productGrid' || $results['dotapp_blocks'][$key]['blockType'] == 'productScroll' || $results['dotapp_blocks'][$key]['blockType'] == 'productSlider') {
					$results['dotapp_blocks'][$key]['products'] = $this->get_products($value['linkId']);
				}

			}
		} else {
			$results['dotapp_blocks'] = array();
		}
		

		$results['local'] = $this->load->controller('extension/restapi/common/local');
		$results['language'] = $this->load->controller('extension/restapi/common/language');
		$results['currency'] = $this->load->controller('extension/restapi/common/currency');
		$results['isLoggedIn'] = $this->customer->isLogged();
		
        $this->load->model('account/customer');

		$results['user'] = (object)array();
		if ($this->customer->isLogged()) {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$results['user'] = array(
				'customer_id' => $this->customer->getId(),
				'customer_group_id' => $customer_info['customer_group_id'],
				'firstname' => $customer_info['firstname'],
				'lastname' => $customer_info['lastname'],
				'email' => $customer_info['email'],
				'telephone' => $customer_info['telephone'],
				'custom_field' => json_decode($customer_info['custom_field'], true)
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
		$this->response->setOutput(json_encode($results));

	}

	public function design_app_details() {

		$results = array();

		$this->load->model('setting/setting');
		
		$results = $this->model_setting_setting->getSetting('dotapp');

		$results['categories'] = $this->get_categories();

		$results['recentProducts'] = $this->get_products(0);

		if(isset($results['dotapp_blocks']) && is_array($results['dotapp_blocks'])) {
			foreach ($results['dotapp_blocks'] as $key => $value) {

				if($results['dotapp_blocks'][$key]['blockType'] == 'productList' || $results['dotapp_blocks'][$key]['blockType'] == 'productGrid' || $results['dotapp_blocks'][$key]['blockType'] == 'productScroll' || $results['dotapp_blocks'][$key]['blockType'] == 'productSlider') {
					$results['dotapp_blocks'][$key]['products'] = $this->get_products($value['linkId']);
				}

			}
		} else {
			$results['dotapp_blocks'] = array();
		}

		$results['local'] = $this->load->controller('extension/restapi/common/local');
		$results['language'] = $this->load->controller('extension/restapi/common/language');
		$results['currency'] = $this->load->controller('extension/restapi/common/currency');
		$results['isLoggedIn'] = $this->customer->isLogged();
		
        $this->load->model('account/customer');

		$results['user'] = (object)array();
		if ($this->customer->isLogged()) {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$results['user'] = array(
				'customer_id' => $this->customer->getId(),
				'customer_group_id' => $customer_info['customer_group_id'],
				'firstname' => $customer_info['firstname'],
				'lastname' => $customer_info['lastname'],
				'email' => $customer_info['email'],
				'telephone' => $customer_info['telephone'],
				'custom_field' => json_decode($customer_info['custom_field'], true)
			);
		}


		$this->load->model('catalog/information');

		$informations = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			$informations[] = array(
				'id' => $result['information_id'],
				'title' => $result['title'],
				'href'  => $this->url->link('extension/restapi/information/information/info', 'information_id=' . $result['information_id'])
			);
		}

		$results['informations'] = $informations;

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$this->response->addHeader("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			$this->response->addHeader('Access-Control-Allow-Credentials: ' . 'true');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($results));

	}

	public function options() {

		$settings = array();

		$this->load->model('setting/setting');
		
		$settings = $this->model_setting_setting->getSetting('dotapp');

		$settings['dotapp_blocks'] = array();
		$settings['dotapp_theme'] = array();

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($settings));
		
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

	public function site_details() {

		$this->load->model('setting/setting');

		$data = array(
			'name' => 'Opencart',
			'description' => ''
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));

	}

	public function image_files() {
		$this->load->language('common/filemanager');

		// Find which protocol to use to pass the full image link back
		/*if ($this->request->server['HTTPS']) {
			$server = HTTPS_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}*/

		if (isset($this->request->get['filter_name'])) {
			$filter_name = rtrim(str_replace(array('*', '/', '\\'), '', $this->request->get['filter_name']), '/');
		} else {
			$filter_name = '';
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace('*', '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$directories = array();
		$files = array();

		$data['images'] = array();

		$this->load->model('tool/image');

		if (substr(str_replace('\\', '/', realpath($directory) . '/' . $filter_name), 0, strlen(DIR_IMAGE . 'catalog')) == str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			// Get directories
			$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

			if (!$directories) {
				$directories = array();
			}

			// Get files
			$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

			if (!$files) {
				$files = array();
			}
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if (isset($this->request->get['target'])) {
					$url .= '&target=' . $this->request->get['target'];
				}

				if (isset($this->request->get['thumb'])) {
					$url .= '&thumb=' . $this->request->get['thumb'];
				}

				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					/*'href'  => $this->url->link('common/filemanager', 'user_token=' . $this->session->data['user_token'] . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, true)*/
				);
			} elseif (is_file($image)) {
				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
					'name'  => implode(' ', $name),
					'type'  => 'image',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					'href'  => 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
				);
			}
		}

		//$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->get['directory'])) {
			$data['directory'] = urlencode($this->request->get['directory']);
		} else {
			$data['directory'] = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if (isset($this->request->get['target'])) {
			$data['target'] = $this->request->get['target'];
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
			}
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		//$data['parent'] = $this->url->link('common/filemanager', 'user_token=' . $this->session->data['user_token'] . $url, true);

		// Refresh
		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode($this->request->get['directory']);
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		//$data['refresh'] = $this->url->link('common/filemanager', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		$pagination = new Pagination();
		$data['total'] = $image_total;
		$data['page'] = $page;
		//$pagination->url = $this->url->link('common/filemanager', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		//$data['pagination'] = $pagination->render();

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));

	}

	public function fcm_details() {

        if(isset($_REQUEST['token'])) {

            $token = $_REQUEST['token'];
        
            $this->load->model('setting/setting');

            $apikey = $this->config->get('mstoreapp_firebase_server_key');


            $url = "https://iid.googleapis.com/iid/info/" . $token . "?details=true";

            $header = array();

			$header[] = 'Content-type: application/json';
			$header[] = 'Authorization: ' . 'key=' . $apikey;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			if (curl_errno($ch)) {
				$this->log('cURL error: ' . curl_errno($ch));
				curl_close($ch);
				$data = array(
					'status' => false
				);
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($data));
				//Send Error Response
				//$this->response->setOutput($response);
			} else {
				$data = (array)json_decode($response);
                $data['topics'] = array();
                if(isset($data['rel'])) {
                    foreach ($data['rel']->topics as $key => $value) {
                        $data['topics'][] = $key;
                    }
                }
                curl_close($ch);
                $this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($data));
			}

        }
    }

}