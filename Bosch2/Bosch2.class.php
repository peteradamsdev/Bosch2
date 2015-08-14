<?php

class Bosch2
{
	public $fields;
	public $labelHTML = '<label for="{{NAME}}">{{LABEL}}</label>';

	function __construct( $fields )
	{
		$this->fields = $fields;
	}

	public function outputLabel($name)
	{
		$label = $this->fields[$name]['label'];
		echo '<label for="'.$name.'">'.$label.'</label>';
	}

	public function outputField($name)
	{
		$field = $this->fields[$name];
		
	}




	public static function exception ( $e )
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