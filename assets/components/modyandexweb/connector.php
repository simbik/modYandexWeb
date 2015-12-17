<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var modYandexWeb $modYandexWeb */
$modYandexWeb = $modx->getService('modyandexweb', 'modYandexWeb', $modx->getOption('modyandexweb_core_path', null, $modx->getOption('core_path') . 'components/modyandexweb/') . 'model/modyandexweb/');
$modx->lexicon->load('modyandexweb:default');

// handle request
$corePath = $modx->getOption('modyandexweb_core_path', null, $modx->getOption('core_path') . 'components/modyandexweb/');
$path = $modx->getOption('processorsPath', $modYandexWeb->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));