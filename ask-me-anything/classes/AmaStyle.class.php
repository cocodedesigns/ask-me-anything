<?php
class AmaStyle {
	private $id;
	
	function __construct() {
		$this->_loadGoogleFonts();
	}
	/**
	 * Returns an array of all font styles defined
	 *
	 * @param	NA
	 * @return	array	$fonts	A list of usable fonts in a array format
	 */
	public function getFontStyles(){
		$fonts = array(
			'System Fonts' => array(
				'serif' => 'Serif',
				'sans-serif' => 'Sans Serif',
			),
			'Google Fonts' => array(
				'Open Sans' => 'Open Sans',
				'Oswald' => 'Oswald',
				'Lora' => 'Lora',
				'Love Ya Like A Sister' => 'Love Ya Like A Sister',
				'Raleway' => 'Raleway',
				'Cinzel' => 'Cinzel',
				'Stalemate' => 'Stalemate',
				'Poller One' => 'Poller One',
				'Eagle Lake' => 'Eagle Lake',
				'The Girl Next Door' => 'The Girl Next Door',
				'Finger Paint' => 'Finger Paint',
				'Frijole' => 'Frijole',
				'Loved by the King' => 'Loved by the King',
				'Happy Monkey' => 'Happy Monkey',
				'Nunito' => 'Nunito'
			)
		);
		return $fonts;
	}
	
	/**
	 * Loads the list of Google fonts onto the page using the JavaScript append method
	 *
	 * @param	NA
	 * @return	NA
	 */
	private function _loadGoogleFonts(){
		$font_list = $this->getFontStyles();
		$fonts = array();
		
		foreach ($font_list['Google Fonts'] as $key => $value) {
			$fonts[] = "'" . str_replace(" ", "+", $key) . "::latin'";
		}
		
		echo "
		<script type=\"text/javascript\">
		  // ** Ask Me Anything Plugin Google web font loader ** //
		  WebFontConfig = {
			google: { families: [ " . implode(', ', $fonts) . " ] }
		  };
		  (function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		  })(); </script>";
	}
}
?>