<?php

/**
 * Create counter
 */
class modYandexWebMetrikaCounterCreateProcessor extends modObjectProcessor {

	public function process(){
		$this->modx->getService('modyandexweb','modYandexWeb', MODX_CORE_PATH.'components/modyandexweb/model/');
		$ya = $this->modx->modyandexweb;
		$counter_name = $this->getProperty('name');
		$counter_url = $_SERVER['HTTP_HOST'];

		$url = 'https://api-metrika.yandex.ru/management/v1/counters';
		$opt = array(
			"counter" => array(
				"name" => $counter_name,
				"site" => $counter_url,
			)
		);

		$results = $ya->yaRequest('POST', $url, $opt);
		if($results['counter']){
			$results['success'] = true;
			$results['object'] = $results['counter'];
		}else{
			$results['success'] = false;
		}
		$results['data'] = array();
		$resp = $results;
		return json_encode($resp);
	}

}

return 'modYandexWebMetrikaCounterCreateProcessor';