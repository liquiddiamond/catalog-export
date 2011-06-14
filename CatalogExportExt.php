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
	 * @package    Catalog Export
	 * @license    LGPL
	 * @filesource
	 */

	class CatalogExportExt extends CatalogExt {

		public function __costruct() {
			parent::__construct();
		}

		public function generateXml($intId='') {
			$objCatalog = $this -> Database -> prepare("SELECT * FROM tl_catalog_types WHERE id=? AND makeFeed=? AND makeXml=?") -> limit(1) -> execute($intId, 1, 1);
			if($objCatalog -> numRows < 1) {
				return ;
			}

			$objCatalog -> exportName = $objCatalog -> tableName;

			if($this -> Input -> get('act') == 'delete') {
				// Delete XML file
				$this -> import('Files');
				$this -> Files -> delete($objCatalog -> exportName . '.xml');
			} else {
				// Update XML file
				$this -> generateFilesAsXml($objCatalog);
				$this -> log('Generated catalog xml "' . $objCatalog -> exportName . '.xml"', 'Catalog generateXml()', TL_CRON);
			}

		}

		/**
		 * Generate a XML file and save it to the root directory
		 * @param arrCatalog Database_Result
		 */
		protected function generateFilesAsXml($arrCatalog) {
			if(!strlen($arrCatalog -> tableName))
				return ;

			$time = time();
			$strLink = $this -> Environment -> base;
			$strFile = $arrCatalog -> exportName;

			$objXml = new FileXml($strFile);

			$objXml -> link = $strLink;
			$objXml -> title = $arrCatalog -> tableName;
			$objXml -> description = $arrCatalog -> name;
			//$objXml -> language = $arrCatalog -> language;
			$objXml -> language = 'en';
			$objXml -> published = $arrCatalog -> tstamp;

			// Get itmes
			$objCatalogItems = $this -> Database -> prepare("SELECT * FROM " . $arrCatalog -> tableName) -> execute();

			// Parse items
			$rows = $objCatalogItems -> fetchAllAssoc();
			foreach ($rows as $row) {
				$objNode = new NodeXml($row);
				$objXml -> addNode($objNode);
			}

			// Create file
			$objCatalog = new File($strFile . '.xml');
			$objCatalog -> write($objXml -> generateXml());
			$objCatalog -> close();
		}

	}
?>