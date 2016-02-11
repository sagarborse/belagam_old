<?php
class ControllerModuleOmfa extends Controller {
	private $error = array();
	

	private $omfa_options = array(
			'config_mobile_theme' => array(
				'name' => 'config_mobile_theme',
				'default' => 'omf'
				),		
			'config_mobile_tablets' => array(
				'name' => 'config_mobile_tablets',
				'default' => ''
				),
			'config_wishlist_disabled' => array(
				'name' => 'config_wishlist_disabled',
				'default' => '0'
				),
			'config_mobile_front_page_cat_list' => array(
				'name' => 'config_mobile_front_page_cat_list',
				'default' => ''
				),
			'config_mobile_display_top_cats' => array(
				'name' => 'config_mobile_display_top_cats',
				'default' => ''
				),
			'config_disable_addtocart_outofstock' => array(
				'name' => 'config_disable_addtocart_outofstock',
				'default' => '1'
				),
		);

	private $xml_files = array("zzz_omf_catalog.xml", "zzz_omf_system.xml");

	public function index()
	{
		$this->data = $this->language->load('module/omfa');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('tool/image');
//if (defined('VERSION') && (version_compare(VERSION, '1.5.5', '<') == true)) {
		$this->data['store_id'] = 0;
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->data['mobile_logo'] = $this->data['no_image'];

		// set defaults
		foreach ($this->omfa_options as $option)
		{
			$this->data[$option['name']] = $option['default'];
		}


	if (defined('VERSION') && (version_compare(VERSION, '1.5.5', '>=') == true))
	{
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (isset($this->request->post['config_mobile_disable_omf'])) {
				$this->disableOmf();
				unset($this->request->post['config_mobile_disable_omf']);
			} else {
				$this->enableOmf();
			}

			$this->model_setting_setting->editSetting('omfa', $this->request->post);


			if (isset($this->error['json']))
			{
				$this->session->data['error'] = implode('<br />', (array)$this->error['json']);
			}
			else
			{
				$this->session->data['success'] = $this->language->get('text_success');
			}

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

//} else {
/*

		foreach ($this->omfa_options as $option)
		{
			$option_name = $option['name'];
			$option_default = $option['default'];

			if (isset($this->request->post[$option_name]))
			{
				$this->data[$option_name] = $this->request->post[$option_name];
			}
			elseif ($this->config->get($option_name))
			{
				$this->data[$option_name] = $this->config->get($option_name);
			}
			else
			{
				$this->data[$option_name] = $option_default;
			}
		}


		if ($this->config->get('config_mobile_logo') && file_exists(DIR_IMAGE . $this->config->get('config_mobile_logo')) && is_file(DIR_IMAGE . $this->config->get('config_mobile_logo'))) {
			$this->data['mobile_logo'] = $this->model_tool_image->resize($this->config->get('config_mobile_logo'), 100, 100);
		} else {
			$this->data['mobile_logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
}
*/
		$this->data['mobile_themes'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		foreach ($directories as $directory)
		{
			if (file_exists($directory.'/stylesheet/mobile.scss'))
			{
				$this->data['mobile_themes'][] = basename($directory);
			}
		}


 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/omfa', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		$this->data['action'] = $this->url->link('module/omfa', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();


		if ($this->isOmfDisabled()) {
			$this->data['config_mobile_disable_omf'] = "1";
		}

		$this->template = 'module/omfa.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function load() { // not needed for v 1.5.5.*
		$this->load->model('setting/setting');

		$json = array();

		if (isset($this->request->get['store_id'])) {
			$store_info = $this->model_setting_setting->getSetting('omfa', $this->request->get['store_id']);
			$store_id = $this->request->get['store_id'];
		} else {
			$store_info = $this->model_setting_setting->getSetting('omfa', 0);
			$store_id = 0;
		}
		$json['store_id'] = $store_id;

		$this->load->model('tool/image');

		if ($store_info)
		{
			foreach ($this->omfa_options as $option)
			{
				$option_name = $option['name'];
				if (isset($this->request->post[$option_name]))
				{
					$json[$option_name] = $this->request->post[$option_name];
				}
				elseif (isset($store_info[$option_name]))
				{
					$json[$option_name] = $store_info[$option_name];
				}
			}

			if ($this->isOmfDisabled()) {
				$json['config_mobile_disable_omf'] = "1";
			}


		}
		else // new store
		{
			// set defaults
			foreach ($this->omfa_options as $option)
			{
				$json[$option['name']] = $option['default'];
			}


			if ( ! $default_store_settings = $this->model_setting_setting->getSetting('omfa', 0)) {
				//save defaults to db
				$this->model_setting_setting->editSetting('omfa', $json, 0);
			}

		}

		$this->response->setOutput(json_encode($json));
	}


	public function save()
	{
		$this->language->load('module/omfa');
		$this->load->model('setting/setting');

		$json = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (isset($this->request->post['config_mobile_disable_omf'])) {	
				$this->disableOmf();
				unset($this->request->post['config_mobile_disable_omf']);
			} else {
				$this->enableOmf();
			}


			$this->model_setting_setting->editSetting('omfa', $this->request->post, $this->request->post['store_id']);

		}


		if (isset($this->error['json'])) {
			$json['error'] = implode('<br />', (array)$this->error['json']);
		}

		if (isset($this->error['warning'])) {
			$json['error'] = $this->error['warning'];
		}

		if ( ! isset($json['error'])) {
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->setOutput(json_encode($json));
	}


	private function isOmfDisabled() {
		$vqmod_dir = "../vqmod/xml/";

		foreach ($this->xml_files as $filename) {
			$file = $vqmod_dir . $filename;
			if (!file_exists($file)) {
				return true;
			}
		}

		return false;
	}

	private function disableOmf() {
		$vqmod_dir = "../vqmod/xml/";
		foreach ($this->xml_files as $filename) {
			$file = $vqmod_dir . $filename;
			if (file_exists($file)) {
				rename($file, $file . "_disabled");
			}
		}
	}

	private function enableOmf() {
		$vqmod_dir = "../vqmod/xml/";

		foreach ($this->xml_files as $filename) {
			$file = $vqmod_dir . $filename;

			if (!file_exists($file)) {
				$file_disabled =  $file . "_disabled";

				if (file_exists($file_disabled)) {
					rename($file_disabled, $file);
				} else {
					$vqmod_files = glob($file . "*");

					if (file_exists($vqmod_files[0])) {
						rename($vqmod_files[0], $file);
					}
				}	
			}
		}

	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/omfa')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function writeToFile($filename, $new_content)
	{
		if ( is_writable($filename))
		{
			file_put_contents($filename, html_entity_decode($new_content, ENT_QUOTES, "UTF-8"));
		}
		else
		{
			(array)$this->error['json'][] = sprintf($this->language->get('error_file_permissions'), $filename);
		}
	}
}

?>