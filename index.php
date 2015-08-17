<?php

	require('Bosch2/init.php');

	$fields = array(
		'demo_text' => 
			array(
				'label'       => 'Demo Text',
				'type'        => 'text',
				'validate'    => 'required',
				'filter'      => 'trim|sanitize_string',
			),
		'demo_select' => 
			array(
				'label'        => 'Demo Select',
				'type'        => 'select',
				'options' => array('' => 'Choose an Option', 'opt1' => 'Option 1', 'opt2' => 'Option 2'),
				'validate'    => 'required',
				'filter'      => 'trim|sanitize_string',
			),
		);

	$form = new Bosch2($fields);

	if ( isset($_POST['submit']) )
	{
		$data = $form->process();

		var_dump($data);
	}

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bosch2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

    	<form name="demo_form" method="post">

    		<?php $form->outputLabel('demo_text'); ?>
    		<?php $form->outputField('demo_text'); ?>

    		<?php $form->outputFull('demo_select'); ?>

    		<?php $form->simpleSubmit('Let\'s Go!'); ?>

    	</form>       
    </body>
</html>
