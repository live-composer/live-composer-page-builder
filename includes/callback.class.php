<?php
/**
* Callback class
*
* AJAX should be:
*
* {
* 	action: 'dslc-callback-request',
*	dslc: 'active'
* 	method: string
* 	params: obj
* }
*/
class DSLC_Callback{

	public static $CLBK = Array();

	/**
	 * Routes AJAX request to inner static methods
	 */
	static function router()
	{
		/// Check if routing possible
		if(isset($_REQUEST) && !empty($_REQUEST) && method_exists(__CLASS__, $_REQUEST['method']."Clbk")){

			$methodName = $_REQUEST['method']."Clbk";
			self::$methodName($_REQUEST['params']);
			self::retJson();
		}else{

			/// If request format is invalid
			self::retJson(Array("error"=>"PHP Callback.router::invalid arguments"));
		}
	}

	/**
	 * Echoes JSON-formatted data
	 */
	static function retJson()
	{
		if(!is_array(self::$CLBK)){

			self::$CLBK['status'] = 'false';
		}

		header("Content-Type: application/json" );
		echo json_encode(self::$CLBK);
		die();
	}

	/**
	 * Returns valid attach url
	 */
	static function getInvalidAttachURLClbk($PARAMS)
	{
		if(intval($PARAMS['attach']['id']) > 0){

			$path = get_attached_file($PARAMS['attach']['id']);

			if(!file_exists($path)){

				return false;
			}

			$attachUrl = wp_get_attachment_image_src($PARAMS['attach']['id'], 'full')[0];
			$DSLC_Aq_Resize = DSLC_Aq_Resize::getInstance();

			self::$CLBK['attach'] = [];
			self::$CLBK['attach']['url'] = $DSLC_Aq_Resize->process(
		        $attachUrl,
				@$_POST['params']['attach']['width'],
				@$_POST['params']['attach']['height']
			);

			self::$CLBK['attach']['id'] = $PARAMS['attach']['id'];
			self::$CLBK['attach']['filename'] = basename($attachUrl);
		}
	}

	/**
	 * Return rendered dynamic parts of module functions
	 *
	 * @param  array $PARAMS
	 */
	static function getDynamicPartsClbk($PARAMS)
	{
		if(is_array($PARAMS['functions'])){

			foreach($PARAMS['functions'] as $functionName){

				$functionNameClear = str_replace("{{", "", $functionName);
				$functionNameClear = str_replace("}}", "", $functionNameClear);

				if(method_exists($PARAMS['moduleId'], $functionNameClear)){

					self::$CLBK[$functionName] = base64_encode($PARAMS['moduleId']::$functionNameClear($PARAMS));
				}
			}
		}

	}
}

add_action('wp_ajax_dslc-callback-request', 'DSLC_Callback::router'); /// One wp_ajax hook instead of thousands of it!
?>