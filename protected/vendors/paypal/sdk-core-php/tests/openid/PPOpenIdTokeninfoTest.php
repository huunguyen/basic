<?php 
/**
 * Test class for PPOpenIdTokeninfo.
 *
 */
class PPOpenIdTokeninfoTest extends PHPUnit_Framework_TestCase {
	
	public $token;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->token = new PPOpenIdTokeninfo();
		$this->token->setAccessToken("Access token")
					->setExpiresIn(900)
					->setRefreshToken("Refresh token")
					->setScope("openid address")
					->setTokenType("Bearer");
	}
	
	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}
	
	/**
	 * @test
	 */
	public function testSerializationDeserialization() {				
		$tokenCopy = new PPOpenIdTokeninfo();
		$tokenCopy->fromJson($this->token->toJson());
		
		$this->assertEquals($this->token, $tokenCopy);
	}
	
	/**
	 * @tes1t
	 */
	public function tes1tOperations() {

		$clientId = 'AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd';
		$clientSecret = 'EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX';

		$params = array(
			'code' => '<FILLME>',
			'redirect_uri' => 'https://devtools-paypal.com/',
			'client_id' => $clientId,
			'client_secret' => $clientSecret
		);
		$accessToken = PPOpenIdTokeninfo::createFromAuthorizationCode($params);
		$this->assertNotNull($accessToken);

		$params = array(
			'refresh_token' => $accessToken->getRefreshToken(),
			'client_id' => $clientId,
			'client_secret' => $clientSecret
		);
		$accessToken = $accessToken->createFromRefreshToken($params);
		$this->assertNotNull($accessToken);
	}

}
