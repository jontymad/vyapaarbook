<?php
class ControllerExtensionRestapiAccountLogin extends Controller {
	private $error = array();

    public function index() {

        $this->load->model('account/customer');

        // Login override for admin users
        if (!empty($this->request->get['token'])) {
            $this->customer->logout();
            $this->cart->clear();

            unset($this->session->data['order_id']);
            unset($this->session->data['payment_address']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['shipping_address']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['comment']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);

            $customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

            if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
                // Default Addresses
                $this->load->model('account/address');

                if ($this->config->get('config_tax_customer') == 'payment') {
                    $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                if ($this->config->get('config_tax_customer') == 'shipping') {
                    $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                //return new Action('extension/restapi/account/account');

                //$this->response->redirect($this->url->link('extension/restapi/account/account', '', true));
            }
        }

        if ($this->customer->isLogged()) {

$data['status'] = true;            
            //return new Action('extension/restapi/account/account');
            //$this->response->redirect($this->url->link('extension/restapi/account/account', '', true));
        }

        $this->load->language('account/login');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // Unset guest
            unset($this->session->data['guest']);

$data['status'] = true;

            // Default Shipping Address
            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            // Wishlist
            if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
                $this->load->model('account/wishlist');

                foreach ($this->session->data['wishlist'] as $key => $product_id) {
                    $this->model_account_wishlist->addWishlist($product_id);

                    unset($this->session->data['wishlist'][$key]);
                }
            }

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
            );

            $this->model_account_activity->addActivity('login', $activity_data);

            // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
                //return new Action('extension/restapi/account/account');
            } else {

                //return new Action('extension/restapi/account/account');
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('extension/restapi/common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('extension/restapi/account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_login'),
            'href' => $this->url->link('extension/restapi/account/login', '', true)
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_new_customer'] = $this->language->get('text_new_customer');
        $data['text_register'] = $this->language->get('text_register');
        $data['text_register_account'] = $this->language->get('text_register_account');
        $data['text_returning_customer'] = $this->language->get('text_returning_customer');
        $data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
        $data['text_forgotten'] = $this->language->get('text_forgotten');

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_password'] = $this->language->get('entry_password');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_login'] = $this->language->get('button_login');

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['action'] = $this->url->link('extension/restapi/account/login', '', true);
        $data['register'] = $this->url->link('extension/restapi/account/register', '', true);
        $data['forgotten'] = $this->url->link('extension/restapi/account/forgotten', '', true);

        // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
        if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
            $data['redirect'] = $this->request->post['redirect'];
        } elseif (isset($this->session->data['redirect'])) {
            $data['redirect'] = $this->session->data['redirect'];

            unset($this->session->data['redirect']);
        } else {
            $data['redirect'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
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

	protected function validate() {
		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['status']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}
		}

		return !$this->error;
	}

 	public function social() {

    	$this->load->model('account/customer');
                        
        if ($this->customer->isLogged()) {
            return new Action('extension/restapi/account/account');
        }

        $user_data = array(
            'first_name' => $this->request->post['firstname'],
            'last_name' => $this->request->post['lastname'],
            'email' => $this->request->post['email'],
            'phone' => $this->request->post['phone'],
            'password' => $this->generate_hash(8),
        );   

        $email = $user_data['email'];

        $customer_info = $this->model_account_customer->getCustomerByEmail($email);

        if (!empty($customer_info)) {
            $customer_id = $customer_info['customer_id'];
	        if (is_numeric($customer_id)) {
	            if ($this->login_customer($customer_id)) {
	                return new Action('extension/restapi/account/account');
	            }
	        }
        }

        if (empty($customer_info)) {
            if (($customer_id = $this->create_customer($user_data)) !== false) {
                if ($this->login_customer($customer_id)) {
					$user_data['status'] = true;
					$this->send_json($user_data);
                    
                }
            }
        }        
    }

    public function create_or_login_user($user_data) {
                    
        $this->load->model('account/customer');

        $email = $user_data['email'];

        if(isset($user_data['email']) && !empty($user_data['email'])) {
            $customer_info = $this->model_account_customer->getCustomerByEmail($email);

            if (!empty($customer_info)) {
                $customer_id = $customer_info['customer_id'];
                $this->login_customer($customer_id);
            }

            if (empty($customer_info)) {
                if (($customer_id = $this->create_customer($user_data)) !== false) {
                   $this->login_customer($customer_id);
                }
            }

        } else {
            if(isset($user_data['phone']) && !empty($user_data['phone'])) {
                $customer_info = $this->getCustomerByTelephone($user_data['phone']);
            } else if(isset($user_data['password']) && !empty($user_data['password'])) {
                $customer_info = $this->getCustomerByPassword($user_data['password']);
            }

            if (!empty($customer_info)) {
                $customer_id = $customer_info['customer_id'];
                $this->loginById($customer_id);
            }

            if (empty($customer_info)) {
                if (($customer_id = $this->create_customer($user_data)) !== false) {
                   $this->loginById($customer_id);
                }
            }
        }
    }                    


 	protected function create_customer($data)
    {

        $customer_data = array(
            'customer_group_id' => $this->config->get('config_customer_group_id'),
            'firstname' => $data['first_name'],
            'lastname' => $data['last_name'],
            'email' => $data['email'],
            'telephone' => $data['phone'],
            'fax' => '',
            'password' => $data['password'],
            'company' => '',
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'postcode' => '',
            'country_id' => 0,
            'zone_id' => 0
        );

        $this->load->model('account/customer');

        $customer_id = $this->model_account_customer->addCustomer($customer_data);

        // Customer Added
        if (is_numeric($customer_id))
        {
            return $customer_id;
        }

        // Error

        return false;
    }

    // Login a customer
    protected function login_customer($customer_id)
    {
        // Retrieve the customer
        $result = $this->db->query("SELECT email FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . intval($customer_id) . "'")->row;
        if (is_array($result))
        {
            // Login
            if ($this->customer->login($result['email'], '', true))
            {
                unset($this->session->data['guest']);

                // Default Shipping Address
                $this->load->model('account/address');

                if ($this->config->get('config_tax_customer') == 'payment')
                {
                    $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                if ($this->config->get('config_tax_customer') == 'shipping')
                {
                    $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                }

                // Add to activity log
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                );

                $this->model_account_activity->addActivity('login', $activity_data);

                // Logged in

                return true;
            }
        }

        // Not logged in

        return false;
    }

    public function loginById($customer_id) {
        $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' AND status = '1'");

        if ($customer_query->num_rows) {
            $this->session->data['customer_id'] = $customer_query->row['customer_id'];

            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
                $cart = unserialize($customer_query->row['cart']);

                foreach ($cart as $key => $value) {
                    if (!array_key_exists($key, $this->session->data['cart'])) {
                        $this->session->data['cart'][$key] = $value;
                    } else {
                        $this->session->data['cart'][$key] += $value;
                    }
                }
            }

            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
                if (!isset($this->session->data['wishlist'])) {
                    $this->session->data['wishlist'] = array();
                }

                $wishlist = unserialize($customer_query->row['wishlist']);

                foreach ($wishlist as $product_id) {
                    if (!in_array($product_id, $this->session->data['wishlist'])) {
                        $this->session->data['wishlist'][] = $product_id;
                    }
                }
            }

            unset($this->session->data['guest']);

            // Default Shipping Address
            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment')
            {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping')
            {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
            );

            $this->model_account_activity->addActivity('login', $activity_data);

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$customer_id . "'");

            return true;
        } else {
            return false;
        }
    }

    protected function generate_hash($length)
    {
        $hash = '';

        for ($i = 0; $i < $length; $i++)
        {
            do
            {
                $char = chr(mt_rand(48, 122));
            } while (!preg_match('/[a-zA-Z0-9]/', $char));

            $hash .= $char;
        }

        return $hash;
    }

    public function social_login() {

    	$this->load->model('account/customer');
        $this->load->language('account/login');

        if ($this->customer->isLogged()) {
        	return new Action('extension/restapi/account/account');
        }

    	if(!isset($_REQUEST['token']) || !isset($_REQUEST['type'])) {
    		$data = array(
                'status' => false,
                'message' => $this->language->get('error_login')
            );
            $this->send_json($data);
    	}

    	else {

		$token = $this->request->post['token'];
        $type = $this->request->post['type'];

        //For testing only google
        //$token = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjNmMzMyYjNlOWI5MjhiZmU1MWJjZjRmOGRhNTQzY2M0YmQ5ZDQ3MjQiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI4MDY1NjUyMDY3MTctMGMzNXVsdGFvdTEyazcyMzluOXJtczVlZG5lMmI5aGkuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI4MDY1NjUyMDY3MTctMGMzNXVsdGFvdTEyazcyMzluOXJtczVlZG5lMmI5aGkuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDYxMjE4MDgwNTE1NDIyOTkxMDUiLCJlbWFpbCI6Imhha2VlbS5uYWxhQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhdF9oYXNoIjoiNFdnb3dMNHltaTlXbC1nTjVJbnVXdyIsIm5vbmNlIjoiU3Z3UzBGMjI5YjZiVWwtRl96MU9nSlBaZWVER1c4ZHA1dDZEX05aNmN3OCIsIm5hbWUiOiJBYmR1bCBIYWtlZW0iLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EtL0FPaDE0R2pVbUExQlZobVhzSS14UkpZN3pFTjB1NGVCcHNuenU1OWRuNkFOPXM5Ni1jIiwiZ2l2ZW5fbmFtZSI6IkFiZHVsIiwiZmFtaWx5X25hbWUiOiJIYWtlZW0iLCJsb2NhbGUiOiJlbi1HQiIsImlhdCI6MTU5OTk3MDIxMSwiZXhwIjoxNTk5OTczODExfQ.JaHenadjMGkZPfU6QpYT4pih1I9HdmeD2dOejasQXwlEakrVpgCVIA_uKBDHwVvNCFkVxVXhMclGs-FaV0z6kTujwuvGcwsDhPSkRMbHO2IdP5q6blB_gZoEhSwhwnXFq567-MVI_PXP8CmPyfNGFQFMkGpFKEtKpkqy3ReZmb76SDlpu9ALzj9pIHpRmTJyjaaMbvCgs1WLN5qQw-pNAq74STbujNpZTlQHDpAbr-FUMnwWkHmkbmDvyAMNZHxtR0fSrlEc3EW7o9oRha1r9c33ImIBgF5tebFfxm2Y5IUjzmL8-hzIwge6yRSm6LgxD0pZOjz4Bts_WzL8pA_9bw';

        //$token = 'EAARIhMRN2d8BAPJ3AEa92Jy81ZCVxDSBZCK8yXNygZBbEUKMyDgJNNmcceaKu15lAQnfKnrBy4OkveklW3LgF3iK8Qe3tth8c2v4TlTZAZAsTlTZB7wgtLZCXYGqNIYUmHisLedtTZAIx3j2BqlKIJj8G9RRS7vprHndaOSHpvsqmXuUdEAh7g64Hj8eNZAD57zkd2oFkqAYC1xycLHxh5oQJJJP8SOFdbBXdNK3lz7F10QZDZD';
        
        //$token = 'AM5PThBLG76eiLjyyi00e1HGrw0d-krTi0DcgylvXPf_o09ySa4SBBLxD3tIfP7i8A0Oymb4O-6Xh58M3ix1TzsFXZH4yVDqw531N72XtX_bvaIIi7BUP66GhkJc0Ewu2LtFR4lc_CY5Vyy5LQv62sUVPfyox6axJA';
        //$type = 'sms';
        
        if($type == 'google') {

            $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $token;
            $response = $this->remote_get( $url );

            if(isset($response['email_verified'])) {
                $user_data = array(
                    'first_name' => $response["given_name"],
                    'last_name' => $response["family_name"],
                    'email' => $response["email"],
                    'phone' => '',
                    'password' => $this->generate_hash(8),
                );
                $this->create_or_login_user($user_data);
                return new Action('extension/restapi/account/account');
            } else {
                $data = array(
                    'status' => false,
                    'message' => $this->language->get('error_login')
                );
                $this->send_json($data);
            }
        }

        if($type == 'facebook') {

            $fields = 'email,name,first_name,last_name,picture';
            $url = 'https://graph.facebook.com/me/?fields=' . $fields . '&access_token=' . $token;

            $response = $this->remote_get( $url );

            if(isset($response['email'])) {
                $user_data = array(
                    'first_name' => $response["first_name"],
                    'last_name' => $response["last_name"],
                    'email' => $response["email"],
                    'phone' => '',
                    'password' => $this->generate_hash(8),
                );
                $this->create_or_login_user($user_data);
                return new Action('extension/restapi/account/account');
            } else {
                $data = array(
                    'status' => false,
                    'message' => $this->language->get('error_login')
                );
                $this->send_json($data);
            }
        }

        if($type == 'apple') {
            
            if(isset($this->request->post['firstname']) && ! empty($this->request->post['firstname'])) {
                $name = $this->request->post['firstname'];
            } else $name = '';

            if(isset($this->request->post['email']) && ! empty($this->request->post['email'])) {
                $email = $this->request->post['email'];
            } else if(isset($this->request->post['userIdentifier']) && ! empty($this->request->post['userIdentifier'])) {
                $email = $this->request->post['userIdentifier'];
            }

            if(isset($email)) {
                $user_data = array(
                    'first_name' => $name,
                    'last_name' => '',
                    'email' => $email,
                    'phone' => '',
                    'password' => $this->generate_hash(8),
                );
                $this->create_or_login_user($user_data);
                return new Action('extension/restapi/account/account');
            } else {
                $data = array(
                    'status' => false,
                    'message' => $this->language->get('error_login')
                );
                $this->send_json($data);
            }
        }

        if($type == 'sms') {

            if(isset($this->request->post['smsOTP']) && ! empty($this->request->post['smsOTP'])) {
                $code = $this->request->post['smsOTP'];
            } else $code = '123456';

            if(isset($this->request->post['email']) && ! empty($this->request->post['email'])) {
                $email = isset($this->request->post['email']);
            } else if(isset($this->request->post['phoneNumber']) && ! empty($this->request->post['phoneNumber'])) {
                $email = $this->request->post['phoneNumber'];
            }

            $data = array(
                'sessionInfo' => $token,
                'code' => $code
            );

            //TODO Add to Opencart settings in admin panel, get firebase_serverkey from settings
            //$firebase_serverkey = 'AIzaSyA01f5MP7dSe_UiZXMvTOVmOVPpQnxEHTc';
            $this->load->model('setting/setting');
            $firebase_serverkey = $this->config->get('mstoreapp_firebase_web_api_key');

            $url = 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPhoneNumber?key=' . $firebase_serverkey;

            $response = $this->remote_get( $url, $data );
            if(isset($response['phoneNumber'])) {
                $user_data = array(
                    'first_name' => '',
                    'last_name' => '',
                    'email' => $email,
                    'phone' => $response['phoneNumber'],
                    'password' => $this->generate_hash(8),
                );
                $this->create_or_login_user($user_data);
                return new Action('extension/restapi/account/account');
            } else if(isset($response['error']) && ($response['error']['message'] == 'SESSION_EXPIRED' || $response['error']['message'] == 'INVALID_SESSION_INFO') ) {
            	$user_data = array(
                    'first_name' => '',
                    'last_name' => '',
                    'email' => $_REQUEST['phoneNumber'],
                    'phone' => $_REQUEST['phoneNumber'],
                    'password' => $this->generate_hash(8),
                );
                $this->create_or_login_user($user_data);
                return new Action('extension/restapi/account/account');
            } else if(isset($response['error'])) {
            	$data = array(
                    'status' => false,
                    'message' => $response['error']['message']
                );
                $this->send_json($data);
            } else {
                $data = array(
                    'status' => false,
                    'message' => $this->language->get('error_login')
                );
                $this->send_json($data);
            }
        }
    	}
        
    }

    public function getCustomerByTelephone($telephone) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(telephone) = '" . $this->db->escape(utf8_strtolower($telephone)) . "'");

        return $query->row;
    }

    public function getCustomerByPassword($password) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(password) = '" . $this->db->escape(utf8_strtolower($password)) . "'");

        return $query->row;
    }

    public function remote_get($url, $data = array()) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_PORT, 443);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        $json = curl_exec($curl);

        if (!$json) {
            
            $this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));

            $this->send_json($this->error['warning']);

        } else {
            $response = json_decode($json, true);

            curl_close($curl);

            return $response;
        }
    }

    function remote_retrieve_body( $response ) {
        if ( ! isset( $response['body'] ) ) {
            return '';
        }

        return $response['body'];
    }

    public function send_json($data) {
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
