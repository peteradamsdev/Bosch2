<?php

class Bosch2
{
	public $fields;

	function __construct($fields)
	{
		$this->fields = $fields;
	}

	public function loadField($name)
	{
		try
		{
			if ( !array_key_exists($name, $this->fields) ){
                throw new Exception('Field name <code>'.$name.'</code> not found');
			}

			return new Bosch2_Field($name, $this->fields[$name]);
		}
		catch (Exception $e) 
		{
            Bosch2::exception($e);                   
        }
	}

	public function outputLabel($name)
	{
		$field = $this->loadField($name);
		echo '<label for="'.$field->name.'">'.$field->label.'</label>';
	}

	public function outputField($name)
	{		
		$field = $this->loadField($name);
		$outputFunc = 'output'.ucfirst($field->type);
		echo $field->$outputFunc();	

		return true;
	}

	public function outputFull($name)
	{
		$this->outputLabel($name);
		$this->outputField($name);
	}

	public function simpleSubmit($label = 'Submit')
	{
		echo '<button type="submit" name="submit" class="btn btn-submit">'.$label.'</button>';
	}

	public function process()
	{
		$data = Bosch2::sanitizePostData();

		foreach( $data as $k => $v )
		{
			$this->fields[$k]['stored_value'] = $v;
			$this->fields[$k] = Bosch2::runFilters($this->fields[$k]);
		}

		return $data;
	}

	public static function sanitizePostData()
    {
        $magic_quotes = (bool) get_magic_quotes_gpc();

        $input = $_POST['Bosch2'];       
        $fields = array_keys($input);
        $return = array();

        foreach ($fields as $field) 
        {
            if (!isset($input[$field])) 
            {
                continue;
            } 
            else 
            {
                $value = $input[$field];
                if (is_array($value)) 
                {
                    $value = null;
                }
                if (is_string($value))
                {
                    if ($magic_quotes === true) 
                    {
                        $value = stripslashes($value);
                    }
                    if (strpos($value, "\r") !== false)
                    {
                        $value = trim($value);
                    }
                    if (function_exists('iconv') && function_exists('mb_detect_encoding') ) 
                    {
                        $current_encoding = mb_detect_encoding($value);
                        if ($current_encoding != 'UTF-8' && $current_encoding != 'UTF-16') 
                        {
                            $value = iconv($current_encoding, 'UTF-8', $value);
                        }
                    }

                    $value = filter_var($value, FILTER_SANITIZE_STRING);
                }

                $return[$field] = $value;
            }
        }

        return $return;
    }

    public static function runFilters($field)
    {
    	$filters = explode('|', $field['filter']);

    	foreach($filters as $filter)
    	{
    		$params = null;

            if (strstr($filter, ',') !== false)
            {
                $filter = explode(',', $filter);
                $params = array_slice($filter, 1, count($filter) - 1);
                $filter = $filter[0];
            }

            if (is_callable(array('Bosch2', 'filter_'.$filter)))
            {
                $method = 'filter_'.$filter;
                $field['stored_value'] = Bosch2::$method($field['stored_value'], $params);
            } 
            elseif (function_exists($filter))
            {
                $field['stored_value'] = $filter($field['stored_value']);
            }
            else
            {
            	throw new Exception("Filter method '$filter' does not exist.");
            }
    	}

    	return $field;
    }

    public static function filter_sanitize_string($value, $params = null)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }


	public static function exception ($e)
	{
        echo '
        <div class="bosch2-exception">
            Exception: <strong>'.$e->getMessage().'</strong><br />
            Found in '.$e->getFile().' on line '.$e->getLine().'<br />
            Code: <pre>'.$e->getTraceAsString().'</pre>
        </div>';

        return true;
    }
}

