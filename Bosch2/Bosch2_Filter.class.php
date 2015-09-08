<?php

	class Bosch2_Filter{

	/**
     * Replace noise words in a string (http://tax.cchgroup.com/help/Avoiding_noise_words_in_your_search.htm).
     *
     * Usage: '<index>' => 'noise_words'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_noise_words($value, $params = null)
    {
        $value = preg_replace('/\s\s+/u', chr(32), $value);

        $value = " $value ";

        $words = explode(',', self::$en_noise_words);

        foreach ($words as $word) {
            $word = trim($word);

            $word = " $word "; // Normalize

            if (stripos($value, $word) !== false) {
                $value = str_ireplace($word, chr(32), $value);
            }
        }

        return trim($value);
    }

    /**
     * Remove all known punctuation from a string.
     *
     * Usage: '<index>' => 'rmpunctuataion'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_rmpunctuation($value, $params = null)
    {
        return preg_replace("/(?![.=$'€%-])\p{P}/u", '', $value);
    }    

    /**
     * Sanitize the string by removing any script tags.
     *
     * Usage: '<index>' => 'sanitize_string'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_sanitize_string($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    /**
     * Sanitize the string by urlencoding characters.
     *
     * Usage: '<index>' => 'urlencode'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_urlencode($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_ENCODED);
    }

    /**
     * Sanitize the string by converting HTML characters to their HTML entities.
     *
     * Usage: '<index>' => 'htmlencode'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_htmlencode($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Sanitize the string by removing illegal characters from emails.
     *
     * Usage: '<index>' => 'sanitize_email'
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_sanitize_email($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize the string by removing illegal characters from numbers.
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_sanitize_numbers($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Filter out all HTML tags except the defined basic tags.
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_basic_tags($value, $params = null)
    {
        return strip_tags($value, self::$basic_tags);
    }

    /**
     * Convert the provided numeric value to a whole number.
     *
     * @param string $value
     * @param array  $params
     *
     * @return string
     */
    public static function filter_whole_number($value, $params = null)
    {
        return intval($value);
    }


	}