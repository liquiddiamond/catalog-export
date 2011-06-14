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
	
	// Update Catalog Callbacks
	$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('tl_module_catalog_export', 'onLoadCallback');
	
	/**
	 * Class tl_module_catalog_export
	 *
	 * Provide miscellaneous methods that are used by the data configuration array.
	 * @copyright  Fabiano Mason 2005-2011
	 * @author     Fabiano Mason <http://www.liquiddiamond.it>
	 * @package    CatalogExport
	 */
	class tl_module_catalog_export extends tl_module_catalog {

		public function onLoadCallback(DataContainer $dc) {
		}
		
		public function generatePdf() {
			die('generatePdf');
		}

	}
?>