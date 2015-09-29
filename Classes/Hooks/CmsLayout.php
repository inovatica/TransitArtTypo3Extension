<?php

namespace INV\TransitArt\Hooks;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Georg Ringer <typo3@ringerge.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Hook to display verbose information about the felogin plugin
 *
 */
class CmsLayout implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface {

    /**
     * Extension key
     *
     * @var string
     */
    const KEY = 'transit_art';

    /**
     * Path to the locallang file
     *
     * @var string
     */
    const LLPATH = 'LLL:EXT:transit_art/Resources/Private/Language/locallang_be.xml:';

    protected $flexformData;
    protected $actionKey;

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param boolean $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     * @return void
     */
    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {
        if ($row['list_type'] === 'transitart_pi1') {

            $result = '';

            $result .= '<strong>' . $this->translate('flexforms.settings.apiKey') . ':</strong>';

            $this->flexformData = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row['pi_flexform']);
            // if flexform data is found
            $apiKey = $this->getFieldFromFlexform('settings.apiKey', 'General');
            $result .= ' ' . $this->translate('flexforms.settings.apiKey.' . $apiKey);
            
            $state = $this->getFieldFromFlexform('settings.state', 'General');
            if($state){
                $result .= '<br/>';
                $result .= '<strong>' . $this->translate('flexforms.settings.state') . ':</strong>';
                $result .= ' ' . $this->translate('flexforms.settings.state.' . $state);
            }

            $itemContent .= $result . '<br/>';
        }
    }
    


    protected function translate($key){
        return $GLOBALS['LANG']->sL(self::LLPATH . $key);
    }

    /**
     * Get field value from flexform configuration,
     * including checks if flexform configuration is available
     *
     * @param string $key name of the key
     * @param string $sheet name of the sheet
     * @return string|NULL if nothing found, value if found
     */
    protected function getFieldFromFlexform($key, $sheet = 'sDEF') {
        $flexform = $this->flexformData;
        if (isset($flexform['data'])) {
            $flexform = $flexform['data'];
            if (is_array($flexform) && is_array($flexform[$sheet]) && is_array($flexform[$sheet]['lDEF']) && is_array($flexform[$sheet]['lDEF'][$key]) && isset($flexform[$sheet]['lDEF'][$key]['vDEF'])
            ) {
                return $flexform[$sheet]['lDEF'][$key]['vDEF'];
            }
        }

        return NULL;
    }

}
