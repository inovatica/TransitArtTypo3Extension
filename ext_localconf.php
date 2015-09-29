<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'INV.' . $_EXTKEY,
	'Pi1',
	array(
		'TransitArt' => 'show',
		
	),
	// non-cacheable actions
	array(
		'TransitArt' => '',
		
	)
);

// Page module hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/CmsLayout.php:INV\TransitArt\Hooks\CmsLayout';
