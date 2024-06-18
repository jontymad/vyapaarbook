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
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');

		$this->load->language('product/category');

		$data['text_product'] = $this->language->get('text_product');

		$this->load->language('module/category');

		$data['text_categories'] = $this->language->get('heading_title');

		$this->load->language('module/account');

		$data['text_register']    = $this->language->get('text_register');
		$data['text_login']       = $this->language->get('text_login');
		$data['text_logout']      = $this->language->get('text_logout');
		$data['text_forgotten']   = $this->language->get('text_forgotten');
		$data['text_account']     = $this->language->get('text_account');
		$data['text_edit']        = $this->language->get('text_edit');
		$data['text_password']    = $this->language->get('text_password');
		$data['text_address']     = $this->language->get('text_address');
		$data['text_wishlist']    = $this->language->get('text_wishlist');
		$data['text_order']       = $this->language->get('text_order');
		$data['text_download']    = $this->language->get('text_download');
		$data['text_reward']      = $this->language->get('text_reward');
		$data['text_return']      = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter']  = $this->language->get('text_newsletter');
		$data['text_recurring']   = $this->language->get('text_recurring');

		$this->load->language('checkout/checkout');

		$data['checkout_title'] = $this->language->get('heading_title');

		$data['text_register']                  = $this->language->get('Register Account');
$data['text_guest']                     = $this->language->get('Guest Checkout');
$data['text_checkout']                  = $this->language->get('Checkout Options');
$data['text_cart']                      = $this->language->get('Shopping Cart');


$this->load->language('account/order');

$data['text_order']            = $this->language->get('Order Information');
$data['text_order_detail']     = $this->language->get('Order Details');
$data['text_shipping_address'] = $this->language->get('Shipping Address');
$data['text_shipping_method']  = $this->language->get('Shipping Method');
$data['text_payment_address']  = $this->language->get('Payment Address');
$data['text_payment_method']   = $this->language->get('Payment Method');



$data['text_edit_address']   = "تحرير عنوان";
$data['text_new_address']   = "العناوين الجديدة";
$data['text_welcome']   = "أهلا بك";
$data['text_products']   = "المنتج";
$data['text_product_details']   = "تفاصيل المنتج";
$data['text_return_product']   = "عودة المنتج";
$data['text_my_address']   = "عنواني";
$data['text_register_account']   = "تسجيل";
$data['text_buy_now']   = "اشتري الآن";
$data['text_menu']   = "قائمة طعام";
$data['text_add']   = "إضافة";

		return $data;
		
	}
	
}
