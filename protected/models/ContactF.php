<?php
/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactF extends CFormModel
{
	public $name;
	public $email;
	public $phone;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, body', 'required',"message" => "<p style='color: red'>{attribute} Không được để trống.</p>"),
			// email has to be a valid email address
			array('email', 'email','message' =>"<p style='color: red'>Email không chính xác</p>"),
                        array('phone', 'match', 'pattern' => '/^([+]?[0-9 ]+)$/', 'message' => "<p style='color: red'>Điện thoại không chính xác</p>"),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}