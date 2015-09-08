<?php

	require('Bosch2/init.php');

	$fields = array(
		'demo_text' => 
			array(
				'label'    => 'Demo Text',
				'type'     => 'text',
				'validate' => 'required',
				'filter'   => 'trim|sanitize_string',
			),
		'demo_select' => 
			array(
				'label'    => 'Demo Select',
				'type'     => 'select',
				'options'  => array('' => 'Choose an Option', 'opt1' => 'Option 1', 'opt2' => 'Option 2'),
				'validate' => 'required',
				'filter'   => 'trim|sanitize_string',
			),
		);

	$form = new Bosch2($fields);

	if ( isset($_POST['submit']) )
	{
		$data = $form->process();

		if ( !$form->has_errors )
		{
			echo 'Finished';
			var_dump($_POST);
		}
	}

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bosch2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="bootstrap.css">
    </head>
    <body>

    	<div class="container">

	    	<?php if ( $form->has_errors ) : ?>

	    		<?php $form->outputErrors(); ?>

	    	<?php endif; ?>

	    	<form name="demo_form" method="post" class="form">

	    		<?php $form->outputLabel('demo_text'); ?>
	    		<?php $form->outputField('demo_text'); ?>

	    		<?php $form->outputFull('demo_select'); ?>

	    		<hr>

	    		<?php $form->simpleSubmit('Let\'s Go!'); ?>

	    	</form>

	    </div>    
    </body>
</html>
