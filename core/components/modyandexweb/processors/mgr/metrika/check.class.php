<?php

/**
 * Remove metrika
 */
class modYandexWebMetrikaCheckCounterProcessor extends modObjectProcessor {

	public function process(){
		$this->modx->getService('modyandexweb','modYandexWeb', MODX_CORE_PATH.'components/modyandexweb/model/');
		$ya = $this->modx->modyandexweb;
		$counter_id = $this->getProperty('counter_id');

		$url = 'https://api-metrika.yandex.ru/management/v1/counter/'.$counter_id.'/check';

		$results = $ya->yaRequest('GET', $url);

		$results['success'] = true;
		$results['data'] = array();

		$resp = $results;
		return json_encode($resp);
	}

}

return 'modYandexWebMetrikaCheckCounterProcessor';