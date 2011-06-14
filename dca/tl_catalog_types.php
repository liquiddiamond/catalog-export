<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

	/**
	 * Contao Open Source CMS
	 * Copyright (C) 2005-2011 Leo Feyer
	 *
	 * Formerly known as TYPOlight Open Source CMS.
	 *
	 * This program is free software: you can redistribute it and/or
	 * modify it under the terms of the GNU Lesser General Public
	 * License as published by the Free Software Foundation, either
	 * version 3 of the License, or (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
	 * Lesser General Public License for more details.
	 * 
	 * You should have received a copy of the GNU Lesser General Public
	 * License along with this program. If not, please visit the Free
	 * Software Foundation website at <http://www.gnu.org/licenses/>.
	 *
	 * PHP version 5
	 * @copyright  Fabiano Mason 2005-2011
	 * @author     Fabiano Mason <http://www.liquiddiamond.it>
	 * @package    CatalogExport
	 * @license    LGPL
	 * @filesource
	 */

	/**
	 * Table tl_catalog_types 
	 */
	
	// Update Catalog Config
	$GLOBALS['TL_DCA']['tl_catalog_types']['config']['onload_callback'][] = array('tl_catalog_types_export', 'generateXml');
	
	// Overwrite Catalog Palettes
	$GLOBALS['TL_DCA']['tl_catalog_types']['palettes'] = array (
		'__selector__'		=> array('addImage', 'import', 'searchable', 'allowComments', 'makeFeed', 'makeXml'),
		'default'					=> '{title_legend},name,tableName,aliasField,publishField,jumpTo;{page_legend:hide},titleField,descriptionField,keywordsField;{display_legend:hide},addImage,format;{comments_legend:hide},allowComments;{search_legend:hide},searchable;{import_legend:hide},import;{feed_legend:hide},makeFeed;{export_legend:hide},makeXml'
	);
	
	// Add Catalog Subpalettes
	$GLOBALS['TL_DCA']['tl_catalog_types']['subpalettes'] = array (
		'addImage'				=> 'singleSRC,size',
		'allowComments'		=> 'template,sortOrder,perPage,moderate,bbcode,requireLogin,disableCaptcha,hideMember,disableWebsite',
		'import'					=> 'importAdmin,importDelete',
		'searchable'			=> 'searchCondition',
		'makeFeed'				=> 'feedFormat,language,source,datesource,feedBase,alias,maxItems,feedTitle,description',
		'makeXml'         => ''
	);
	
	// Add Catalog Fields
	$GLOBALS['TL_DCA']['tl_catalog_types']['fields']['makeXml'] = array (
		'label'      => &$GLOBALS['TL_LANG']['tl_catalog_types']['makeXml'],
		'exclude'    => true,
		'inputType'  => 'checkbox',
		'eval'       => array('submitOnChange'=>false),
		'doNotCopy'  => true
	);
	
	class tl_catalog_types_export extends tl_catalog_types {
	
		/**
		 * Update Export XML
		 */
		public function generateXml() {
			$this->import('CatalogExportExt');
			$this->CatalogExportExt->generateXml(CURRENT_ID);
		}
		
	}

?>