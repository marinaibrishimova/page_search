<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('html_purify'))
{
	function html_purify($dirty_html, $config = FALSE)
	{
		require_once APPPATH . 'third_party/htmlpurifier-4.4.0-standalone/HTMLPurifier.standalone.php';

		if (is_array($dirty_html))
		{
			foreach ($dirty_html as $key => $val)
			{
				$clean_html[$key] = html_purify($val);
			}
		}

		else
		{
			switch ($config)
			{
				case 'comment':
					$config = HTMLPurifier_Config::createDefault();
					$config->set('Cache.DefinitionImpl', null);
					$config->set('CSS.Trusted', TRUE);
					
					$safeiframesources = array('www.youtube.com/embed/',
		                               'player.vimeo.com/video/',                               
        		                       );
				    $config->set('HTML.SafeIframe', true);
				    $config->set('URI.SafeIframeRegexp',	
                     '%^https?://('.implode('|', $safeiframesources).')%');

					break;

				case FALSE:
					$config = HTMLPurifier_Config::createDefault();

					break;

				default:
					show_error('The HTMLPurifier configuration labeled "' . htmlentities($config, ENT_QUOTES, 'UTF-8') . '" could not be found.');
			}

			$purifier = new HTMLPurifier($config);
			$clean_html = $purifier->purify($dirty_html);
		}

		return $clean_html;
	}
}

/* End of htmlpurifier_helper.php */
/* Location: ./application/helpers/htmlpurifier_helper.php */
?> 