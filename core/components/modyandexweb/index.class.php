<?php

/**
 * Class modYandexWebMainController
 */
abstract class modYandexWebMainController extends modExtraManagerController {
	/** @var modYandexWeb $modYandexWeb */
	public $modYandexWeb;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('modyandexweb_core_path', null, $this->modx->getOption('core_path') . 'components/modyandexweb/');
		require_once $corePath . 'model/modyandexweb/modyandexweb.class.php';

		$this->modYandexWeb = new modYandexWeb($this->modx);
		//$this->addCss($this->modYandexWeb->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/modyandexweb.js');
		$this->addHtml('
		<script type="text/javascript">
			modYandexWeb.config = ' . $this->modx->toJSON($this->modYandexWeb->config) . ';
			modYandexWeb.config.connector_url = "' . $this->modYandexWeb->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('modyandexweb:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends modYandexWebMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}