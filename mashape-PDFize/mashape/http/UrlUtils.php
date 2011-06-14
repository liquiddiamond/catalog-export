<?php

/*
 * Mashape PHP Client library.
 *
 * Copyright (C) 2011 Mashape, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * The author of this software is Mashape, Inc.
 * For any question or feedback please contact us at: support@mashape.com
 *
 */

define("CLIENT_LIBRARY_LANGUAGE", "PHP");
define("CLIENT_LIBRARY_VERSION", "V03");

define("TOKEN", "_token");
define("LANGUAGE", "_language");
define("VERSION", "_version");

define("PLACEHOLDER_REGEX", "/\{([\w\.]+)\}/");
class UrlUtils {

	public static function prepareRequest(&$url, &$parameters, $addRegularQueryStringParameters = false) {
		if ($parameters == null) {
			$parameters = array();
		}
		// Remove null parameters
		$keys = array_keys($parameters);
		for ($i = 0;$i<count($keys);$i++) {
			$key = $keys[$i];
			if ($parameters[$key] === null) {
				unset($parameters[$key]);
			} else {
				$parameters[$key] = (string)$parameters[$key];
			}
		}

		if ($addRegularQueryStringParameters) {
			// Get regular query string parameters
			self::addRegularQueryStringParameters($url, $parameters);
		}


		$finalUrl = $url;
		$matches = null;
		$match = preg_match_all(PLACEHOLDER_REGEX, $url, $matches);

		if (!empty($matches) && count($matches) > 1) {
			$matches = $matches[1];
			$count = count($matches);
			foreach ($matches as $key) {
				if (array_key_exists($key, $parameters)) {
					$finalUrl = preg_replace("/(\?.+)\{" . $key . "\}/", '${1}' . urlencode($parameters[$key]), $finalUrl);
					$finalUrl = preg_replace("/\{" . $key . "\}/", rawurlencode($parameters[$key]), $finalUrl);
				} else {
					$finalUrl = preg_replace("/&?[\w]*=?\{" . $key . "\}/", "", $finalUrl);
				}
			}
		}

		$finalUrl = preg_replace("/\?&/", "?", $finalUrl);
		$finalUrl = preg_replace("/\?$/", "", $finalUrl);
		$url = $finalUrl;
	}

	private static function addRegularQueryStringParameters($url, &$parameters) {
		$urlParts = explode("?", $url);
		if (count($urlParts) > 1) {
			$queryString = $urlParts[1];
			$queryStringParameters = explode("&", $queryString);
			foreach ($queryStringParameters as $queryStringParameter) {
				$queryStringParameterParts = explode("=", $queryStringParameter);
				if (count($queryStringParameterParts) > 1) {
					if (!self::isPlaceHolder($queryStringParameterParts[1])) {
						$parameters[$queryStringParameterParts[0]] = $queryStringParameterParts[1];
					}
				}
			}
		}
	}

	private static function isPlaceHolder($value) {
		return preg_match(PLACEHOLDER_REGEX, $value);
	}

	public static function addClientParameters(&$url, &$parameters, $token) {
		if ($parameters == null) {
			$parameters = array();
		}

		if (strpos($url, "?") === false) {
			$url .= "?";
		} else {
			$url .= "&";
		}

		$url .= self::addClientParameter(TOKEN);
		$parameters[TOKEN] = $token;
		$url .= "&" . self::addClientParameter(LANGUAGE);
		$parameters[LANGUAGE] = CLIENT_LIBRARY_LANGUAGE;
		$url .= "&" . self::addClientParameter(VERSION);
		$parameters[VERSION] = CLIENT_LIBRARY_VERSION;
	}

	private static function addClientParameter($parameter) {
		return $parameter . "={" . $parameter . "}";
	}

}

?>