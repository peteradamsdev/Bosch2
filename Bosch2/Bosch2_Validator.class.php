<?php

class Bosch2_Validator{

	/**
     * Verify that a value is contained within the pre-defined value set.
     *
     * Usage: '<index>' => 'contains,value value value'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_contains($field, $param = null)
    {
        if (!isset($field->stored_value)) {
            return;
        }

        $param = trim(strtolower($param));

        $value = trim(strtolower($field->stored_value));

        if (preg_match_all('#\'(.+?)\'#', $param, $matches, PREG_PATTERN_ORDER)) {
            $param = $matches[1];
        } else {
            $param = explode(chr(32), $param);
        }

        if (in_array($value, $param)) { // valid, return nothing
            return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Verify that a value is contained within the pre-defined value set.
     * OUTPUT: will NOT show the list of values.
     *
     * Usage: '<index>' => 'contains_list,value;value;value'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_contains_list($field, $param = null)
    {
        $param = trim(strtolower($param));

        $value = trim(strtolower($field->stored_value));

        $param = explode(';', $param);

        // consider: in_array(strtolower($value), array_map('strtolower', $param)

        if (in_array($value, $param)) { // valid, return nothing
            return;
        } else {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Verify that a value is NOT contained within the pre-defined value set.
     * OUTPUT: will NOT show the list of values.
     *
     * Usage: '<index>' => 'doesnt_contain_list,value;value;value'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_doesnt_contain_list($field, $param = null)
    {
        $param = trim(strtolower($param));

        $value = trim(strtolower($field->stored_value));

        $param = explode(';', $param);

        if (!in_array($value, $param)) { // valid, return nothing
            return;
        } else {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Check if the specified key is present and not empty.
     *
     * Usage: '<index>' => 'required'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_required($field, $param = null)
    {
        if (isset($field->stored_value) && ($field->stored_value === false || $field->stored_value === 0 || $field->stored_value === 0.0 || $field->stored_value === '0' || !empty($field->stored_value))) {
            return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided email is valid.
     *
     * Usage: '<index>' => 'valid_email'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_valid_email($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!filter_var($field->stored_value, FILTER_VALIDATE_EMAIL)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value length is less or equal to a specific value.
     *
     * Usage: '<index>' => 'max_len,240'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_max_len($field, $param = null)
    {
        if (!isset($field->stored_value)) {
            return;
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen($field->stored_value) <= (int) $param) {
                return;
            }
        } else {
            if (strlen($field->stored_value) <= (int) $param) {
                return;
            }
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided value length is more or equal to a specific value.
     *
     * Usage: '<index>' => 'min_len,4'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_min_len($field, $param = null)
    {
        if (!isset($field->stored_value)) {
            return;
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen($field->stored_value) >= (int) $param) {
                return;
            }
        } else {
            if (strlen($field->stored_value) >= (int) $param) {
                return;
            }
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided value length matches a specific value.
     *
     * Usage: '<index>' => 'exact_len,5'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_exact_len($field, $param = null)
    {
        if (!isset($field->stored_value)) {
            return;
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen($field->stored_value) == (int) $param) {
                return;
            }
        } else {
            if (strlen($field->stored_value) == (int) $param) {
                return;
            }
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided value contains only alpha characters.
     *
     * Usage: '<index>' => 'alpha'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_alpha($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!preg_match('/^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+$/i', $field->stored_value) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value contains only alpha-numeric characters.
     *
     * Usage: '<index>' => 'alpha_numeric'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_alpha_numeric($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!preg_match('/^([a-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+$/i', $field->stored_value) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value contains only alpha characters with dashed and underscores.
     *
     * Usage: '<index>' => 'alpha_dash'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_alpha_dash($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!preg_match('/^([a-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_-])+$/i', $field->stored_value) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value contains only alpha numeric characters with spaces.
     *
     * Usage: '<index>' => 'alpha_space'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_alpha_space($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!preg_match("/^([a-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\s])+$/i", $field->stored_value) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid number or numeric string.
     *
     * Usage: '<index>' => 'numeric'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_numeric($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!is_numeric($field->stored_value)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid integer.
     *
     * Usage: '<index>' => 'integer'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_integer($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (filter_var($field->stored_value, FILTER_VALIDATE_INT) === false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a PHP accepted boolean.
     *
     * Usage: '<index>' => 'boolean'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_boolean($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value) && $field->stored_value !== 0) {
            return;
        }

        if($field->stored_value === true || $field->stored_value === false) {
          return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided value is a valid float.
     *
     * Usage: '<index>' => 'float'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_float($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (filter_var($field->stored_value, FILTER_VALIDATE_FLOAT) === false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid URL.
     *
     * Usage: '<index>' => 'valid_url'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_valid_url($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!filter_var($field->stored_value, FILTER_VALIDATE_URL)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if a URL exists & is accessible.
     *
     * Usage: '<index>' => 'url_exists'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_url_exists($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $url = parse_url(strtolower($field->stored_value));

        if (isset($url['host'])) {
            $url = $url['host'];
        }

        if (function_exists('checkdnsrr')) {
            if (checkdnsrr($url) === false) {
                return array('rule' => __FUNCTION__, 'param' => $param);
            }
        } else {
            if (gethostbyname($url) == $url) {
                return array('rule' => __FUNCTION__, 'param' => $param);
            }
        }
    }

    /**
     * Determine if the provided value is a valid IP address.
     *
     * Usage: '<index>' => 'valid_ip'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_valid_ip($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!filter_var($field->stored_value, FILTER_VALIDATE_IP) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid IPv4 address.
     *
     * Usage: '<index>' => 'valid_ipv4'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     *
     * @see http://pastebin.com/UvUPPYK0
     */

    /*
     * What about private networks? http://en.wikipedia.org/wiki/Private_network
     * What about loop-back address? 127.0.0.1
     */
    public static function validate_valid_ipv4($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!filter_var($field->stored_value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            // removed !== FALSE

            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid IPv6 address.
     *
     * Usage: '<index>' => 'valid_ipv6'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_valid_ipv6($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!filter_var($field->stored_value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the input is a valid credit card number.
     *
     * See: http://stackoverflow.com/questions/174730/what-is-the-best-way-to-validate-a-credit-card-in-php
     * Usage: '<index>' => 'valid_cc'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_valid_cc($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $number = preg_replace('/\D/', '', $field->stored_value);

        if (function_exists('mb_strlen')) {
            $number_length = mb_strlen($number);
        } else {
            $number_length = strlen($number);
        }

        $parity = $number_length % 2;

        $total = 0;

        for ($i = 0; $i < $number_length; ++$i) {
            $digit = $number[$i];

            if ($i % 2 == $parity) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $total += $digit;
        }

        if ($total % 10 == 0) {
            return; // Valid
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the input is a valid human name [Credits to http://github.com/ben-s].
     *
     * See: https://github.com/Wixel/GUMP/issues/5
     * Usage: '<index>' => 'valid_name'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_valid_name($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!preg_match("/^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïñðòóôõöùúûüýÿ '-])+$/i", $field->stored_value) !== false) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided input is likely to be a street address using weak detection.
     *
     * Usage: '<index>' => 'street_address'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_street_address($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        // Theory: 1 number, 1 or more spaces, 1 or more words
        $hasLetter = preg_match('/[a-zA-Z]/', $field->stored_value);
        $hasDigit = preg_match('/\d/', $field->stored_value);
        $hasSpace = preg_match('/\s/', $field->stored_value);

        $passes = $hasLetter && $hasDigit && $hasSpace;

        if (!$passes) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided value is a valid IBAN.
     *
     * Usage: '<index>' => 'iban'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_iban($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        static $character = array(
            'A' => 10, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16,
            'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22,
            'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28,
            'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34,
            'Z' => 35, 'B' => 11
        );

        if (!preg_match("/\A[A-Z]{2}\d{2} ?[A-Z\d]{4}( ?\d{4}){1,} ?\d{1,4}\z/", $field->stored_value)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }

        $iban = str_replace(' ', '', $field->stored_value);
        $iban = substr($iban, 4).substr($iban, 0, 4);
        $iban = strtr($iban, $character);

        if (bcmod($iban, 97) != 1) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided input is a valid date (ISO 8601).
     *
     * Usage: '<index>' => 'date'
     *
     * @param string $field
     * @param string $input date ('Y-m-d') or datetime ('Y-m-d H:i:s')
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_date($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $cdate1 = date('Y-m-d', strtotime($field->stored_value));
        $cdate2 = date('Y-m-d H:i:s', strtotime($field->stored_value));

        if ($cdate1 != $field->stored_value && $cdate2 != $field->stored_value) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided input meets age requirement (ISO 8601).
     *
     * Usage: '<index>' => 'min_age,13'
     *
     * @param string $field
     * @param string $input date ('Y-m-d') or datetime ('Y-m-d H:i:s')
     * @param string $param int
     *
     * @return mixed
     */
    public static function validate_min_age($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $cdate1 = new DateTime(date('Y-m-d', strtotime($field->stored_value)));
        $today = new DateTime(date('d-m-Y'));

        $interval = $cdate1->diff($today);
        $age = $interval->y;

        if ($age <= $param) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided numeric value is lower or equal to a specific value.
     *
     * Usage: '<index>' => 'max_numeric,50'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     *
     * @return mixed
     */
    public static function validate_max_numeric($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (is_numeric($field->stored_value) && is_numeric($param) && ($field->stored_value <= $param)) {
            return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided numeric value is higher or equal to a specific value.
     *
     * Usage: '<index>' => 'min_numeric,1'
     *
     * @param string $field
     * @param array  $input
     * @param null   $param
     * @return mixed
     */
    public static function validate_min_numeric($field, $param = null)
    {
        if (!isset($field->stored_value)) {
            return;
        }

        if (is_numeric($field->stored_value) && is_numeric($param) && ($field->stored_value >= $param)) {
            return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided value starts with param.
     *
     * Usage: '<index>' => 'starts,Z'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_starts($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (strpos($field->stored_value, $param) !== 0) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

      /**
       * checks if a file was uploaded.
       *
       * Usage: '<index>' => 'required_file'
       *
       * @param  string $field
       * @param  array $input
       *
       * @return mixed
       */
      public static function validate_required_file($field, $param = null)
      {
          if ($field->stored_value['error'] !== 4) {
              return;
          }

          return array('rule' => __FUNCTION__, 'param' => $param);
      }

    /**
     * check the uploaded file for extension
     * for now checks onlt the ext should add mime type check.
     *
     * Usage: '<index>' => 'starts,Z'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_extension($field, $param = null)
    {
        if ($field->stored_value['error'] !== 4) {
            $param = trim(strtolower($param));
            $allowed_extensions = explode(';', $param);

            $path_info = pathinfo($field->stored_value['name']);
            $extension = $path_info['extension'];

            if (in_array($extension, $allowed_extensions)) {
                return;
            }

            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Determine if the provided field value equals current field value.
     *
     * Usage: '<index>' => 'equalsfield,Z'
     *
     * @param string $field
     * @param string $input
     * @param string $param field to compare with
     *
     * @return mixed
     */
    public static function validate_equalsfield($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if ($field->stored_value == $input[$param]) {
          return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Determine if the provided field value is a valid GUID (v4)
     *
     * Usage: '<index>' => 'guidv4'
     *
     * @param string $field
     * @param string $input
     * @param string $param field to compare with
     * @return mixed
     */
    public static function validate_guidv4($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (preg_match("/\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/", $field->stored_value)) {
          return;
        }

        return array('rule' => __FUNCTION__, 'param' => $param);
    }

    /**
     * Trims whitespace only when the value is a scalar.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    private function trimScalar($value)
    {
        if (is_scalar($value)) {
            $value = trim($value);
        }

        return $value;
    }

    /**
     * Determine if the provided value is a valid phone number.
     *
     * Usage: '<index>' => 'phone_number'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     *
     * Examples:
     *
     *  555-555-5555: valid
     *	5555425555: valid
     *	555 555 5555: valid
     *	1(519) 555-4444: valid
     *	1 (519) 555-4422: valid
     *	1-555-555-5555: valid
     *	1-(555)-555-5555: valid
     */
    public static function validate_phone_number($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $regex = '/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i';
        if (!preg_match($regex, $field->stored_value)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Custom regex validator.
     *
     * Usage: '<index>' => 'regex,/your-regex-expression/'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_regex($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        $regex = $param;
        if (!preg_match($regex, $field->stored_value)) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }

    /**
     * Json validatior.
     *
     * Usage: '<index>' => 'valid_json_string'
     *
     * @param string $field
     * @param array  $input
     *
     * @return mixed
     */
    public static function validate_valid_json_string($field, $param = null)
    {
        if (!isset($field->stored_value) || empty($field->stored_value)) {
            return;
        }

        if (!is_string($field->stored_value) || !is_object(json_decode($field->stored_value))) {
            return array('rule' => __FUNCTION__, 'param' => $param);
        }
    }
}