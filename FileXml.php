<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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

	class FileXml extends System {

		/**
		 * Feed name
		 * @var string
		 */
		protected $strName;

		/**
		 * Data array
		 * @var array
		 */
		protected $arrData = array();

		/**
		 * Nodes
		 * @var array
		 */
		protected $arrNodes = array();

		/**
		 * Take an array of arguments and initialize the object
		 * @param string
		 */
		public function __construct($strName) {
			parent::__construct();
			$this -> strName = $strName;
		}

		/**
		 * Set an object property
		 * @param string
		 * @param mixed
		 */
		public function __set($strKey, $varValue) {
			$this -> arrData[$strKey] = $varValue;
		}

		/**
		 * Return an object property
		 * @return mixed
		 */
		public function __get($strKey) {
			return $this -> arrData[$strKey];
		}

		/**
		 * Check whether a property is set
		 * @param string
		 * @return boolean
		 */
		public function __isset($strKey) {
			return    isset($this -> arrData[$strKey]);
		}

		/**
		 * Add an Node
		 * @param objNode NodeXml
		 */
		public function addNode($objNode) {
			$this -> arrNodes[] = $objNode;
		}

		/**
		 * Generate a XML flie
		 */

		public function generateXml() {

			$xml = '<?xml version="1.0" encoding="' . $GLOBALS['TL_CONFIG']['characterSet'] . '"?>' . "\n";
			$xml .= '<root>' . "\n";
			$xml .= '<catalog name="' . specialchars($this -> strName) . '" descriprion="' . specialchars($this -> description) . '">' . "\n";

			foreach($this -> arrNodes as $node) {
				$xml .= $node -> generateNode();
			}

			$xml .= '</catalog>' . "\n";
			$xml .= '</root>';

			return $xml;
		}

	}

	class NodeXml {
		/**
		 * Data array
		 * @var array
		 */
		protected $arrData = array();

		/**
		 * Take an array of arguments and initialize the object
		 * @param array
		 */
		public function __construct($arrData=false) {
			if(is_array($arrData)) {
				$this -> arrData = $arrData;
			}
		}

		/**
		 * Set an object property
		 * @param string
		 * @param mixed
		 */
		public function __set($strKey, $varValue) {
			$this -> arrData[$strKey] = $varValue;
		}

		/**
		 * Return an object property
		 * @return mixed
		 */
		public function __get($strKey) {
			return $this -> arrData[$strKey];
		}

		/**
		 * Check whether a property is set
		 * @param string
		 * @return boolean
		 */
		public function __isset($strKey) {
			return    isset($this -> arrData[$strKey]);
		}

		public function generateNode($hasProps=true) {
			$node = '<row>' . "\n";
			foreach($this->arrData as $key => $value) {
				if($hasProps) {
					$node .= '<column id="' . $key . '">' . specialchars($value) . '</column>' . "\n";
				} else {
					$node .= '<column>' ."\n";
					$node .= '<key>' . $key . '</key><value>' . specialchars($value) . '</value>' . "\n";
					$node .= '</column>' . "\n";
				}
			}

			$node .= '</row>' . "\n";
			return $node;
		}

	}
?>