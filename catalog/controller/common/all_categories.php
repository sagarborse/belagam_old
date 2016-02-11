<?php  
class ControllerCommonAllCategories extends Controller {
	public function index() {	
		if(!$this->isVisitorMobile()) {
			$this->redirect($this->url->link('common/home'));
		} else {
			$this->document->setTitle($this->config->get('config_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));

			$this->data['heading_title'] = $this->config->get('config_title');
			
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/all_categories.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/common/all_categories.tpl';
			} else {
				$this->template = 'default/template/common/all_categories.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
		}
		$this->response->setOutput($this->render());
	}
}
?>