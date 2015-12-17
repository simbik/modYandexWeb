<?php

/**
 * The home manager controller for modYandexWeb.
 *
 */
class modYandexWebHomeManagerController extends modYandexWebMainController {
	/* @var modYandexWeb $modYandexWeb */
	public $modYandexWeb;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('modyandexweb');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->modYandexWeb->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->modYandexWeb->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/webmaster/webmaster.grid.js');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/metrika/metrika.grid.js');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/home.panel.js');
		$this->addJavascript($this->modYandexWeb->config['jsUrl'] . 'mgr/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "modyandexweb-page-home"});
		});
		</script>');
	}

}