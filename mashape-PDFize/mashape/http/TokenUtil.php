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

require_once(dirname(__FILE__) . "/../exceptions/MashapeClientException.php");
require_once(dirname(__FILE__) . "/HttpMethod.php");
require_once(dirname(__FILE__) . "/HttpClient.php");

define("TOKEN_URL", "https://api.mashape.com/requestToken?devkey={devkey}");

class TokenUtil {

	public static function requestToken($developerKey) {
		$parameters = array("devkey"=>$developerKey);

		$response = HttpClient::doRequest(HttpMethod::POST, TOKEN_URL, $parameters, null);

		if (empty($response->errors)) {
			$token = $response->token;
			return $token;
		} else {
			throw new MashapeClientException($response->errors[0]->message, $response->errors[0]->code);
		}
	}

}

?>