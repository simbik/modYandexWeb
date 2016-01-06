<?php

/**
 * The base class for modYandexWeb.
 */
class modYandexWeb {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('modyandexweb_core_path', $config, $this->modx->getOption('core_path') . 'components/modyandexweb/');
		$assetsUrl = $this->modx->getOption('modyandexweb_assets_url', $config, $this->modx->getOption('assets_url') . 'components/modyandexweb/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/',

			'ya_access_token' => $this->modx->getOption('modyandexweb_access_token'),


		), $config);

		//$this->modx->addPackage('modyandexweb', $this->config['modelPath']);
		$this->modx->lexicon->load('modyandexweb:default');
	}

	public function yaRequest($method='GET', $url, $options = array())
	{
		$url .= (strpos($url, '?')===false ? '?' : '&') . http_build_query(array('oauth_token'=>$this->config['ya_access_token']));
		return json_decode($this->rawRequest($method, $url, $options), true);
	}

	protected function rawRequest($method='GET', $url, $options = array())
	{
		$curlOpt = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => false,

			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_TIMEOUT => 20,

			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYPEER => false,
		);

		switch (strtoupper($method)){
			case 'DELETE':
				$curlOpt[CURLOPT_CUSTOMREQUEST] = "DELETE";
			case 'GET':
				if (!empty($options))
					$url .= (strpos($url, '?')===false ? '?' : '&') . http_build_query($options);
				break;
			case 'PUT':
				$body = http_build_query($options);
				$fp = fopen('php://temp/maxmemory:256000', 'w');
				if (!$fp)
					throw new YandexApiException('Could not open temp memory data');
				fwrite($fp, $body);
				fseek($fp, 0);
				$curlOpt[CURLOPT_PUT] = 1;
				$curlOpt[CURLOPT_BINARYTRANSFER] = 1;
				$curlOpt[CURLOPT_INFILE] = $fp; // file pointer
				$curlOpt[CURLOPT_INFILESIZE] = strlen($body);
				break;
			case 'POST':
				$curlOpt[CURLOPT_HTTPHEADER] = array('Content-Type: application/json; charset=UTF-8;');
				$curlOpt[CURLOPT_POST] = true;
				$curlOpt[CURLOPT_POSTFIELDS] = json_encode($options);
				break;
			default:
				throw new YandexApiException("Unsupported request method '$method'");
		}

		$curl = curl_init($url);
		curl_setopt_array($curl, $curlOpt);
		$return = curl_exec($curl);
		$err_no = curl_errno($curl);
		if ($err_no === 0) {
			curl_close($curl);
			return $return;
		} else {
			$err_msg = curl_error($curl);
			curl_close($curl);
			throw new YandexApiException($err_msg, $err_no);
		}
	}


}