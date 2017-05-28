# Q2A Logical Captcha

## Description

This is a plugin for **Question2Answer** that serves simple logical questions for anti spam verification . 

This uses services provided by **textcaptcha.com** API . 

## Advantages 

- based on `Text Captcha API` 
- Pretty simple, easy and logical questions for verification
- all possible answers for one question 
- random questions are choosen out of 180,243,205 questions from the database 
- less repetitive questions , so it is harder to decode by the bots 

## How to Install

The installation is pretty simple . 
- Download the ZIP file and Extract it.
- Place directory called `q2a-logical-captcha` in qa-plugin folder.
- Get your TextRecaptcha API key after doing a quick registration here - http://textcaptcha.com/register
- Navigate to Admin -> Plugins -> Q2A Logical Captcha , set your API key there 
- Navigate to Admin -> Plugins -> Q2A Logical Captcha , set a Random String in the Salt field , which is adds additional security to your captcha . Any string is allowed for this field . 
- Navigate to Admin -> Spam , Set the field `Use captcha module:` as **Q2A Logical Captcha**
- Done


## Disclaimer

It is probably okay for production environments, but may not work exactly as expected.  Refunds will not be given.  If it breaks, you get to keep both parts.

## Language Support

You have the flexibility to change the language by adding a language file of your choice . But the questions will be always in English . No other language questions are supported as of now . 

## About q2A

Question2Answer is a free and open source platform for Q&A sites. For more information, visit:

http://www.question2answer.org/

