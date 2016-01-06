<?php

/**
 * Remove metrika
 */
class modYandexWebMetrikaRemoveProcessor extends modObjectProcessor {

	public function process(){
		$this->modx->getService('modyandexweb','modYandexWeb', MODX_CORE_PATH.'components/modyandexweb/model/');
		$ya = $this->modx->modyandexweb;
		$counter_id = $this->getProperty('counter_id');

		$url = 'https://api-metrika.yandex.ru/management/v1/counter/'.$counter_id;

		$results = $ya->yaRequest('DELETE', $url);

		$resp = $results;
		return json_encode($resp);
	}

}

return 'modYandexWebMetrikaRemoveProcessor';