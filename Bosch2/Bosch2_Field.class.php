<?php

class Bosch2_Field
{
	public $name;
	public $label;
	public $error_label;
	public $type;
	public $default;
	public $stored_value;
	public $current_value;
	public $validate;
	public $options;
	public $filter;
	public $errors = array();
	public $has_error;

	function __construct($name, $properties)
	{
		$this->name = $name;

		foreach( $properties as $k => $v )
		{
			$this->$k = $v;
		}

		if ( !isset($this->error_label) || $this->error_label === '' )
		{
			$this->error_label = ucwords(str_replace('_', ' ', $this->label));
		}

		if ( isset($this->stored_value) )
		{
			$this->current_value = $this->stored_value;
		}
		else
		{
			$this->current_value = $this->default;
		}
	}

	public function outputErrors()
	{
		echo implode('<br />', $this->getErrors());
	}

	public function getErrors()
	{
		$label = '<a class="label-error" href="#'.$this->name.'"><strong>'.$this->error_label.'</strong></a>';

		foreach( $this->errors as $error )
		{
			$param = isset($error['param']) ? $error['param'] : null;

			switch ($error['rule'])
	        {
	            case 'mismatch' :
	                $resp[] = "There is no validation rule for $field";
	                break;
	            case 'validate_required' :
	                $resp[] = "The $label field is required";
	                break;
	            case 'validate_valid_email':
	                $resp[] = "The $label field is required to be a valid email address";
	                break;
	            case 'validate_max_len':
	                $resp[] = "The $label field needs to be $param or shorter in length";
	                break;
	            case 'validate_min_len':
	                $resp[] = "The $label field needs to be $param or longer in length";
	                break;
	            case 'validate_exact_len':
	                $resp[] = "The $label field needs to be exactly $param characters in length";
	                break;
	            case 'validate_alpha':
	                $resp[] = "The $label field may only contain alpha characters(a-z)";
	                break;
	            case 'validate_alpha_numeric':
	                $resp[] = "The $label field may only contain alpha-numeric characters";
	                break;
	            case 'validate_alpha_dash':
	                $resp[] = "The $label field may only contain alpha characters &amp; dashes";
	                break;
	            case 'validate_numeric':
	                $resp[] = "The $label field may only contain numeric characters";
	                break;
	            case 'validate_integer':
	                $resp[] = "The $label field may only contain a numeric value";
	                break;
	            case 'validate_boolean':
	                $resp[] = "The $label field may only contain a true or false value";
	                break;
	            case 'validate_float':
	                $resp[] = "The $label field may only contain a float value";
	                break;
	            case 'validate_valid_url':
	                $resp[] = "The $label field is required to be a valid URL";
	                break;
	            case 'validate_url_exists':
	                $resp[] = "The $label URL does not exist";
	                break;
	            case 'validate_valid_ip':
	                $resp[] = "The $label field needs to contain a valid IP address";
	                break;
	            case 'validate_valid_cc':
	                $resp[] = "The $label field needs to contain a valid credit card number";
	                break;
	            case 'validate_valid_name':
	                $resp[] = "The $label field needs to contain a valid human name";
	                break;
	            case 'validate_contains':
	                $resp[] = "The $label field needs to contain one of these values: ".implode(', ', $param);
	                break;
	            case 'validate_contains_list':
	                $resp[] = "The $label field needs contain a value from its drop down list";
	                break;
	            case 'validate_doesnt_contain_list':
	                $resp[] = "The $label field contains a value that is not accepted";
	                break;
	            case 'validate_street_address':
	                $resp[] = "The $label field needs to be a valid street address";
	                break;
	            case 'validate_date':
	                $resp[] = "The $label field needs to be a valid date";
	                break;
	            case 'validate_min_numeric':
	                $resp[] = "The $label field needs to be a numeric value, equal to, or higher than $param";
	                break;
	            case 'validate_max_numeric':
	                $resp[] = "The $label field needs to be a numeric value, equal to, or lower than $param";
	                break;
	            case 'validate_starts':
	                $resp[] = "The $label field needs to start with $param";
	                break;
	            case 'validate_extension':
	                $resp[] = "The $label field can have the following extensions $param";
	                break;
	            case 'validate_required_file':
	                $resp[] = "The $label field is required";
	                break;
	            case 'validate_equalsfield':
	                $resp[] = "The $label field does not equal $param field";
	                break;
	            case 'validate_min_age':
	                $resp[] = "The $label field needs to have an age greater than or equal to $param";
	                break;
	            default:
	                $resp[] = "The $label field is invalid";
	        }
		}

		return $resp;
	}

	public function outputText()
	{
		$html = '
		<input type="text" class="form-control '.$this->has_error.'" name="Bosch2['.$this->name.']" id="'.$this->name.'" value="'.$this->current_value.'">';

		return $html;
	}

	public function outputSelect()
	{
		$html = '
		<select id="'.$this->name.'" class="form-control '.$this->has_error.'" name="Bosch2['.$this->name.']">';

			foreach( $this->options as $k => $v  )
			{
				$html .= '<option value="'.$k.'">'.$v.'</option>';
			}

			$html .= '
		</select>';

		return $html;
	}
}