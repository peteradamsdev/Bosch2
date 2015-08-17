<?php

class Bosch2_Field
{
	public $name;
	public $label;
	public $type;
	public $default;
	public $stored_value;
	public $current_value;
	public $validate;
	public $options;
	public $filter;
	public $errors;
	public $has_error;

	function __construct($name, $properties)
	{
		$this->name = $name;

		foreach( $properties as $k => $v )
		{
			$this->$k = $v;
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