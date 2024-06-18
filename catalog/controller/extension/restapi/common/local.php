<?php
class ControllerExtensionRestapiCommonLocal extends Controller {
	public function index() {
	
		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');

		$this->load->language('common/footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

        $this->load->language('account/account');

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
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');

		$this->load->language('product/category');

		$data['text_product'] = $this->language->get('text_product');

		$this->load->language('module/account');

		//$data['text_register']    = $this->language->get('text_register');
		$data['text_login']       = $this->language->get('text_login');
		$data['text_logout']      = $this->language->get('text_logout');
		$data['text_forgotten']   = $this->language->get('text_forgotten');
		$data['text_account']     = $this->language->get('text_account');
		$data['text_edit']        = $this->language->get('text_edit');
		$data['text_modify_address']     = $this->language->get('text_address');
		$data['text_modify_wishlist']    = $this->language->get('text_wishlist');
		$data['text_order']       = $this->language->get('text_order');
		$data['text_download']    = $this->language->get('text_download');
		$data['text_reward']      = $this->language->get('text_reward');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter']  = $this->language->get('text_newsletter');
		$data['text_recurring']   = $this->language->get('text_recurring');

		$this->load->language('account/login');

		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_register_account'] = $this->language->get('text_register');
		$data['text_register_account_text'] = $this->language->get('text_register_account');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$this->load->language('account/register');

		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');


		$this->load->language('account/forgotten');

		$data['button_back'] = $this->language->get('button_back');
		$data['text_your_email'] = $this->language->get('text_your_email');
		$data['forgot_text_email'] = $this->language->get('text_email');


		$this->load->language('checkout/checkout');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_shipping'] = $this->language->get('entry_shipping');

		$data['checkout_title'] = $this->language->get('heading_title');

		//$data['text_register']                  = $this->language->get('Register Account');
		$data['text_guest']                     = $this->language->get('Guest Checkout');
		$data['text_checkout']                  = $this->language->get('Checkout Options');
		$data['text_shipping_cart']             = $this->language->get('Shopping Cart');


		$this->load->language('account/order');

		$data['text_order']            = $this->language->get('Order Information');
		$data['text_order_detail']     = $this->language->get('Order Details');
		$data['text_shipping_address'] = $this->language->get('Shipping Address');
		$data['text_shipping_method']  = $this->language->get('Shipping Method');
		$data['text_payment_address']  = $this->language->get('Payment Address');
		$data['text_payment_method']   = $this->language->get('Payment Method');
		$data['text_empty_order'] = $this->language->get('text_empty');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');

		$data['button_view'] = $this->language->get('button_view');

		$this->load->language('extension/total/coupon');

		$data['heading_coupon'] = $this->language->get('heading_title');
		$data['error_coupon'] = $this->language->get('error_coupon');
		$data['error_empty'] = $this->language->get('error_empty');
		$data['entry_coupon'] = $this->language->get('entry_coupon');

		$this->load->language('checkout/checkout');

		$data['error_shipping'] = $this->language->get('error_shipping');
		$data['error_payment'] = $this->language->get('error_payment');
		$data['error_country'] = $this->language->get('error_country');
		$data['error_login'] = $this->language->get('error_login');

		$this->load->language('product/product');

		$data['tab_description'] = $this->language->get('tab_description');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_review'] = $this->language->get('tab_review');
		$data['text_write_review'] = $this->language->get('text_write');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_review'] = $this->language->get('entry_review');
		$data['entry_rating'] = $this->language->get('entry_rating');

		$this->load->language('common/language');

		$data['text_language'] = $this->language->get('text_language');

		$this->load->language('checkout/checkout');

		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['button_continue'] = $this->language->get('button_continue');

		$this->load->language('extension/module/mstoreapp');

		$data['text_edit']   = $this->language->get('text_edit');
		$data['text_welcome']   = $this->language->get('text_welcome');
		$data['text_products']   = $this->language->get('text_products');
		$data['text_product_details']   = $this->language->get('text_product_details');
		$data['text_return_product']   = $this->language->get('text_return_product');

		$data['text_buy_now']   = $this->language->get('text_buy_now');
		$data['text_menu']   = $this->language->get('text_menu');
		$data['text_add']   = $this->language->get('text_add');
		$data['text_success']   = $this->language->get('text_success');
		$data['text_error']   = $this->language->get('text_error');
		$data['text_apply']   = $this->language->get('text_apply');

		$data['text_confirm_order']   = $this->language->get('text_confirm_order');
		$data['text_error_return_reason']   = $this->language->get('text_error_return_reason');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_wishlist']    = $this->language->get('text_wishlist');
		$data['text_address']     = $this->language->get('text_address');
		$data['text_orders']     = $this->language->get('text_orders');
		$data['text_add_to_cart']     = $this->language->get('text_add_to_cart');
		$data['text_currency']     = $this->language->get('text_currency');
		$data['text_settings']     = $this->language->get('text_settings');
		$data['text_cart_empty']     = $this->language->get('text_cart_empty');
		$data['text_display']     = $this->language->get('text_display');
		$data['text_dark_theme']     = $this->language->get('text_dark_theme');

		$data['text_email']     = $this->language->get('text_email');
		$data['text_cancel']     = $this->language->get('text_cancel');
		$data['text_continue']     = $this->language->get('text_continue');

		$data['text_firstname']     = $this->language->get('text_firstname');
		$data['text_lastname']     = $this->language->get('text_lastname');

		//Delete and Replace with entry_telephone
		$data['text_phonenumber']     = $this->language->get('text_phonenumber');
		//Delete and Replace with button_continue
		$data['text_button_continue']   = $this->language->get('text_button_continue');

		$data['text_privacypolicy']     = $this->language->get('text_privacypolicy');
		$data['text_shippingmethod']     = $this->language->get('text_shippingmethod');
		$data['text_paymentmethod']     = $this->language->get('text_paymentmethod');
		$data['text_placeorder']     = $this->language->get('text_placeorder');
		$data['text_ordersummary']     = $this->language->get('text_ordersummary');

		$data['text_whatsapp_us']     = $this->language->get('text_whatsapp_us');
		$data['text_rate_us']     = $this->language->get('text_rate_us');
		$data['text_invite_friends']     = $this->language->get('text_invite_friends');

		$data['text_share_app']     = $this->language->get('text_share_app');
		$data['text_check_out_this_app']     = $this->language->get('text_check_out_this_app');
		$data['facebook']     = $this->language->get('facebook');

		$data['google']     = $this->language->get('google');
		$data['or_continue_with']     = $this->language->get('or_continue_with');
		$data['text_invite_friends']     = $this->language->get('text_invite_friends');

		$data['text_enter_otp']     = $this->language->get('text_enter_otp');
		$data['text_invalid_code']     = $this->language->get('text_invalid_code');
		$data['text_verify_otp']     = $this->language->get('text_verify_otp');
		$data['text_please_enter_phonenumber']     = $this->language->get('text_please_enter_phonenumber');
		$data['text_verify_number']     = $this->language->get('text_verify_number');
		$data['text_invalid_number']     = $this->language->get('text_invalid_number');

		$data['text_chat']     = $this->language->get('text_chat');
		$data['text_no_conversations_yet']     = $this->language->get('text_no_conversations_yet');
		$data['text_support']     = $this->language->get('text_support');
		$data['text_type_message']     = $this->language->get('text_type_message');
		$data['text_please_enter_message']     = $this->language->get('text_please_enter_message');
		$data['text_attachment_image']     = $this->language->get('text_attachment_image');
		$data['text_have_an_account']     = $this->language->get('text_have_an_account');
		$data['text_dont_have_an_account']     = $this->language->get('text_dont_have_an_account');

		return $data;
		
	}
	
}
