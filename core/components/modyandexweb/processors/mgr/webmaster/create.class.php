<?php

/**
 * Create an Item
 */
class modYandexWebItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'modYandexWebItem';
	public $classKey = 'modYandexWebItem';
	public $languageTopics = array('modyandexweb');
	//public $permission = 'create';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$name = trim($this->getProperty('name'));
		if (empty($name)) {
			$this->modx->error->addField('name', $this->modx->lexicon('modyandexweb_item_err_name'));
		}
		elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
			$this->modx->error->addField('name', $this->modx->lexicon('modyandexweb_item_err_ae'));
		}

		return parent::beforeSet();
	}

}

return 'modYandexWebItemCreateProcessor';