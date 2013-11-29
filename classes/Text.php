<?php defined('SYSPATH') OR die('No direct script access.');

class Text extends Kohana_Text {

	public static function censor($str, $badwords, $replacement = '#', $replace_partial_words = TRUE)
	{
		foreach ( (array) $badwords as $key => $badword)
		{
			$badwords[$key] = str_replace('\*', '\S*?', preg_quote( (string) $badword));
		}

		$regex = '('.implode('|', $badwords).')';

		if ($replace_partial_words === FALSE)
		{
			// Just using \b isn't sufficient when we need to replace a badword that already contains word boundaries itself
			$regex = '(?<=\b|\s|^)'.$regex.'(?=\b|\s|$)';
		}

		$regex = '!'.$regex.'!ui';

		if (UTF8::strlen($replacement) == 1)
		{
			return preg_replace_callback($regex, function ($m) { return str_repeat($replacement, UTF8::strlen($m[1])); }, $str);
		}

		return preg_replace($regex, $replacement, $str);
	}

}