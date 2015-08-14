<?php

	require('Bosch2/init.php');

	$fields = array(

		'demo_text' => 
			array(
				'label'        => 'Demo Text',
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

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bosch2</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        
    </head>
    <body>

    	<form name="demo_form" method="post">

    		<?php $form->outputLabel('demo_text'); ?>
    		<?php $form->outputField('demo_text'); ?>

    		<?php $form->outputFull('demo_select'); ?>

    	</form>       
    </body>
</html>
