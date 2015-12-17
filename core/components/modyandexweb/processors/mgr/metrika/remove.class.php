<?php

/**
 * Remove an Items
 */
class modYandexWebItemRemoveProcessor extends modObjectProcessor {
	public $objectType = 'modYandexWebItem';
	public $classKey = 'modYandexWebItem';
	public $languageTopics = array('modyandexweb');
	//public $permission = 'remove';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('modyandexweb_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var modYandexWebItem $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('modyandexweb_item_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}

}

return 'modYandexWebItemRemoveProcessor';