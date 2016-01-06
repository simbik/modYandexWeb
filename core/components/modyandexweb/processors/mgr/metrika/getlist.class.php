<?php

/**
 * Get a list of Items
 */
class modYandexWebMetrikaGetListProcessor extends modObjectProcessor {

	public function process(){
		$this->modx->getService('modyandexweb','modYandexWeb', MODX_CORE_PATH.'components/modyandexweb/model/');
		$ya = $this->modx->modyandexweb;
		$url = 'https://api-metrika.yandex.ru/management/v1/counters?';

		if(!$this->modx->getOption('modyandexweb_advanced_mode')){
			$url .= '&search_string='.$_SERVER['HTTP_HOST'];
		}

		$counters = $ya->yaRequest('GET', $url);

		$results = $counters['counters'];

		foreach($results as $key=>$result){
			$result['actions'] = array();

			switch($result['permission']){
				case 'view':

					break;
				case 'edit':
					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-refresh',
						'title' => $this->modx->lexicon('modyandexweb_counter_check'),
						'action' => 'checkCounter',
						'button' => true,
						'menu' => true,
					);

					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-edit',
						'title' => $this->modx->lexicon('modyandexweb_counter_update'),
						'action' => 'updateCounter',
						'button' => true,
						'menu' => true,
					);

					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-code',
						'title' => $this->modx->lexicon('modyandexweb_counter_showhtml'),
						'action' => 'showHtml',
						'button' => true,
						'menu' => true,
					);
					break;
				case 'own':
					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-refresh',
						'title' => $this->modx->lexicon('modyandexweb_counter_check'),
						'action' => 'checkCounter',
						'button' => true,
						'menu' => true,
					);

					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-edit',
						'title' => $this->modx->lexicon('modyandexweb_counter_update'),
						'action' => 'updateCounter',
						'button' => true,
						'menu' => true,
					);

					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-code',
						'title' => $this->modx->lexicon('modyandexweb_counter_showhtml'),
						'action' => 'showHtml',
						'button' => true,
						'menu' => true,
					);

					$result['actions'][] = array(
						'cls' => '',
						'icon' => 'icon icon-trash-o action-red',
						'title' => $this->modx->lexicon('modyandexweb_counter_remove'),
						'action' => 'removeCounter',
						'button' => true,
						'menu' => true,
					);
					break;
			}

			$results[$key] = $result;
		}

		$resp = array(
			"success" => true,
			"total"	  => count($results),
			"results" => $results,
		);
		return json_encode($resp);
	}

}

return 'modYandexWebMetrikaGetListProcessor';