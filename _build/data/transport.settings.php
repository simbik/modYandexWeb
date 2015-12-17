<?php

$settings = array();

$tmp = array(
	'app_id' => array(
		'xtype' => 'textfield',
		'value' => '51cb0b6d09f44eb487b26a2b7b1f94eb',
		'area' => 'modyandexweb_main',
	),
	'app_secret' => array(
		'xtype' => 'textfield',
		'value' => '48d4d6fe3c4544eeba4d564e160fce96',
		'area' => 'modyandexweb_main',
	),
	'access_token' => array(
		'xtype' => 'textfield',
		'value' => '9239c603ff5f4c30955f804a18f2dcb2',
		'area' => 'modyandexweb_main',
	),
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'modyandexweb_' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
