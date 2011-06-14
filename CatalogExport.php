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
	 
	class CatalogExport extends Catalog {
			
		public function __construct() {
			parent::__construct();
		}
		
		public function initializeCatalogItems($strTable) {

			$tableName = parent::initializeCatalogItems($strTable);
			
			// Update dca: Add the XML export
			array_insert($GLOBALS['TL_DCA'][$tableName]['list']['global_operations'], 1, array (
				'export_xml' => array (
					'label'      => $GLOBALS['TL_LANG']['tl_catalog_items']['export_xml'],
					'href'       => 'key=export_xml',
					'class'      => 'header_css_export',
					'attributes' => 'onclick="Backend.getScrollOffset();"'
					)
				)
			);

			return $tableName;
		}
		
		public function exportXml($dc) {

			if($this -> Input -> get('key') != 'export_xml') {
				return '';
			}

			$objCatalog = $this -> Database -> prepare("SELECT id,tableName FROM tl_catalog_types WHERE id=?")
				-> limit(1)
				-> execute($dc -> id);

			if(!$objCatalog -> numRows) {
				return '';
			}

			// get fields
			$objFields = $this -> Database -> prepare("SELECT colName, type, calcValue FROM tl_catalog_fields WHERE pid=? ORDER BY sorting")
				-> execute($objCatalog -> id);

			$arrFields = array();
			while($objFields -> next()) {
				$arrFields[] = ($objFields -> type != 'calc') ? $objFields -> colName : '(' . $objFields -> calcValue . ') AS ' . $objFields -> colName . '_calc';
			}

			// get records
			$arrExport = array();
			$objRow = $this -> Database -> prepare("SELECT " . implode(', ', $arrFields) . " FROM " . $objCatalog -> tableName . " WHERE pid=?")
				-> execute($objCatalog -> id);

			if($objRow -> numRows) {
				$arrExport = $objRow -> fetchAllAssoc();
			}

			// start output
			$exportFile = 'export_' . $objCatalog -> tableName . '_' . date("Ymd-Hi");

			header('Content-Type: text/xml');
			header('Content-Transfer-Encoding: binary');
			header('Content-Disposition: attachment; filename="' . $exportFile . '.xml"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Expires: 0');

			$xml = '<?xml version="1.0" encoding="' . $GLOBALS['TL_CONFIG']['characterSet'] . '"?>' . "\n";
			$xml .= '<root>' . "\n";
			$xml .= '	<catalog name="' . specialchars($objCatalog -> tableName) . '">' . "\n";

			foreach($arrExport as $export) {
				$xml .= '		<row>' . "\n";
				foreach ($export as $key => $value) {
					$xml .= '			<column id="' . $key . '">' . specialchars($value) . '</column>' . "\n";
				}
				$xml .= '		</row>' . "\n";
			}

			$xml .= '	</catalog>' . "\n";
			$xml .= '</root>';

			echo $xml;
			exit;
			
		}

	}
?>
