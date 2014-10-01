<?php

/*
	Question2Answer (c) Gideon Greenspan
	Q2A Logical captcha (c) Amiya Sahu <developer.amiya@gmail.com>

	http://www.question2answer.org/

	
	File: /qa-plugin/q2a-logical-captcha/qa-plugin.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Initiates reCAPTCHA plugin


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

/*
	Plugin Name: Q2A Logical Captcha
	Plugin URI: https://github.com/amiyasahu/q2a-logical-captcha
	Plugin Description: Protect bot action by adding simple logical questions to Q2A form.
	Plugin Version: 1.1
	Plugin Date: 2014-10-2
	Plugin Author: Amiya Sahu
	Plugin Author URI: http://amiyasahu.com/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.6
	Plugin Update Check URI: https://raw.github.com/amiyasahu/q2a-logical-captcha/master/qa-plugin.php
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	qa_register_plugin_phrases('qa-lcap-lang-*.php', 'lcap');
	qa_register_plugin_module('captcha', 'qa-logical-captcha.php', 'qa_logical_captcha', 'Q2A Logical Captcha');
	

/*
	Omit PHP closing tag to help avoid accidental output
*/