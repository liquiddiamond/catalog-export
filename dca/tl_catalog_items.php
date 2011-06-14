<?php if(!defined('TL_ROOT')) die('You can not access this file directly!');

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
	
	// Update Catalog Items Callbacks
	$GLOBALS['TL_DCA']['tl_catalog_items']['config']['oncreate_callback'][] = array('CatalogExport', 'initializeCatalogItems');
	$GLOBALS['TL_DCA']['tl_catalog_items']['config']['onload_callback'][]   = array('tl_catalog_types_export', 'generateXml');
	
	class tl_catalog_items_export extends tl_catalog_items {
	}
?>