<?php

/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: /qa-plugin/q2a-logical-captcha/qa-logical-captcha.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Captcha module for VSBP


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

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	class qa_logical_captcha {
		const SAVE_BTN             = 'ami_lcap_save' ;
		const API_KEY              = 'ami_lcap_api_key' ;
		const SALT                 = 'ami_lcap_salt' ;
		const CAPTCHA_ANSWER       = 'ami_lcap_answer' ;
		const CAPTCHA_HIDDEN_FIELD = 'ami_lcap_answer_hidden[]' ;
		const CAPTCHA_HIDDEN_NAME  = 'ami_lcap_answer_hidden' ;
		
		var $directory;
		
		function load_module($directory, $urltoroot) {
			$this->directory=$directory;
		}

		function option_default($option) {
			if($option == self::API_KEY)
				return '' ;
		}

		function admin_form() {
			$saved=false;
			
			if (qa_clicked(self::SAVE_BTN)) {
				qa_opt(self::API_KEY , qa_post_text(self::API_KEY));
				qa_opt(self::SALT , qa_post_text(self::SALT));
				$saved=true;
			}

			$form=array(
				'ok' => $saved ? qa_lang('admin/options_saved') : null,
				'fields' => array(
					self::API_KEY => array(
						'type' => 'text',
						'tags' => 'name="'.self::API_KEY.'"',
						'label' => qa_lang_html('lcap/api_key'),
						'value' => qa_opt(self::API_KEY),
						'note' => qa_lang('lcap/get_the_api_key'),
					),
					self::SALT => array(
						'type' => 'text',
						'tags' => 'name="'.self::SALT.'"',
						'label' => qa_lang_html('lcap/salt'),
						'value' => qa_opt(self::SALT),
						'note' => qa_lang('lcap/get_the_salt'),
					),
				),
				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						 'tags' => 'NAME="'.self::SAVE_BTN.'"',
					),
				),
			);
			return $form;
		}

		function recaptcha_error_html()
		{
			if ( (!strlen(trim(qa_opt(self::API_KEY)))) ) {
				$url = "http://textcaptcha.com/register" ;
				return 'To use Logical captcha features , you must <a href="'.qa_html($url).'">sign up</a> to get these API Key.';
			}
			
			return null;				
		}
		
		function allow_captcha()
		{
			return strlen(trim(qa_opt(self::API_KEY))) ;
		}

		function form_html(&$qa_content, $error) {
			$lable = qa_lang('lcap/please_answer');
			
			$text_captcha_url = "http://api.textcaptcha.com/";
			$lc_api_key_value = qa_opt(self::API_KEY);

			// load captcha using web service
			$url = $text_captcha_url . $lc_api_key_value;
			try
			{ 
				$xml = @new SimpleXMLElement($url,null,true);
			} catch (Exception $e) {
				// if there is a problem, use static fallback..
				$fallback = '<captcha>' .
				'<question>Out of a rose, novel, dog, table, piano, or automobile, which is most likely to have teeth?</question>' .
				'<answer>'.md5(md5('dog').qa_opt(self::SALT)).'</answer></captcha>';
				$xml = new SimpleXMLElement($fallback);
			} // try

			$question = (string) $xml->question;
			$ans_hidden_field = '' ;
			
			foreach ($xml->answer as $hash)
			{ 
				$ans = (string) md5($hash.qa_opt(self::SALT));
				$ans_hidden_field .= '<input type="hidden" value="'.$ans.'" name="'.self::CAPTCHA_HIDDEN_FIELD.'" />'.PHP_EOL ;
			}

			$html  = '<div class="qa-lcap">
						<div class="qa-lcap-lable">'.$lable.'</div>			
							<label class="qa-lcap-question" for="'.self::CAPTCHA_ANSWER.'" style="font-weight:700;">'.$question.'</label>	
							<input class="qa-lcap-answer" name="'.self::CAPTCHA_ANSWER.'" id="'.self::CAPTCHA_ANSWER.'" type="text" autocapitalize="off" autocorrect="off" autocomplete="off" required="required"/>
							'. $ans_hidden_field .'
					  </div>' ;
			
			return $html;
		}

		function validate_post(&$error) {
			$hased_answer = (array)@$_POST[self::CAPTCHA_HIDDEN_NAME];

			if (empty($hased_answer)) {
				$error = qa_lang('lcap/invalid_verification_code');
				return false;
			}

			$user_answer = trim(@$_POST[self::CAPTCHA_ANSWER]);
			if (empty($user_answer)) {
				$error = qa_lang('lcap/answer_to_the_q');
				return false;
			}

			$user_answer = strtolower($user_answer); 
			$user_answer = md5(md5($user_answer).qa_opt(self::SALT)) ;
			
			if (!in_array($user_answer, $hased_answer )){
				// verification failed 
				$error = qa_lang('lcap/answer_to_the_q');
				return false;
			}else {
				return true;
			}

			return false;
		}
		
	}
	

/*
	Omit PHP closing tag to help avoid accidental output
*/