<?php

//if ( ! function_exists('url_title'))
//{
	/**
	 * Create URL Title
	 *
	 * Takes a "title" string as input and creates a
	 * human-friendly URL string with a "separator" string
	 * as the word separator.
	 *
	 * @todo	Remove old 'dash' and 'underscore' usage in 3.1+.
	 * @param	string	$str		Input string
	 * @param	string	$separator	Word separator
	 *			(usually '-' or '_')
	 * @param	bool	$lowercase	Wether to transform the output string to lowercase
	 * @return	string
	 */
	function url_title($str, $separator = '-', $lowercase = FALSE)
	{

	setlocale(LC_CTYPE, 'en_IE.UTF-8');
	$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str); //Transliterate into ASCII

        if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
				'&.+?;'			=> '',
				'[^a-z0-9 _-]'		=> '',
				'\s+'			=> $separator,
				'('.$q_separator.')+'	=> $separator
			);

		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i', $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}
//}

// ------------------------------------------------------------------------
