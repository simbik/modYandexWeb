<?php

$settings = array();

$tmp = array(
	'app_id' => array(
		'xtype' => 'textfield',
		'value' => '2a6b4c5c629d432fac674c3dbb69770a',
		'area' => 'modyandexweb_main',
	),
	'app_secret' => array(
		'xtype' => 'textfield',
		'value' => 'dcd1233d354d43659d484835ab61246e',
		'area' => 'modyandexweb_main',
	),
	'access_token' => array(
		'xtype' => 'textfield',
		'value' => '2a49ad1b3bf34df0b2cc9bc2e2609123',
		'area' => 'modyandexweb_main',
	),
	'advanced_mode' => array(
		'xtype' => 'combo-boolean',
		'value' => false,
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
