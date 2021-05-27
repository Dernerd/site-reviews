<?php defined( 'WPINC' ) || die; ?>

<form method="post" action="" name="glsr-<?= $form_id; ?>" class="<?= $class; ?>">
<?php

	echo $html->renderField(['type' => 'honeypot']);

	echo $html->renderField([
		'type'       => 'select',
		'name'       => 'rating',
		'class'      => 'glsr-star-rating',
		'errors'     => $errors,
		'label'      => __( 'Deine Gesamtbewertung', 'site-reviews' ),
		'prefix'     => false,
		'render'     => !in_array( 'rating', $exclude ),
		'suffix'     => $form_id,
		'value'      => $values['rating'],
		'options'    => [
			''  => __( 'Wähle eine Bewertung', 'site-reviews' ),
			'5' => __( 'Ausgezeichnet', 'site-reviews' ),
			'4' => __( 'Sehr gut', 'site-reviews' ),
			'3' => __( 'Durchschnittlich', 'site-reviews' ),
			'2' => __( 'Schlecht', 'site-reviews' ),
			'1' => __( 'Schrecklich', 'site-reviews' ),
		],
	]);

	echo $html->renderField([
		'type'        => 'text',
		'name'        => 'title',
		'errors'      => $errors,
		'label'       => __( 'Titel deiner Bewertung', 'site-reviews' ),
		'placeholder' => __( 'Fasse Deine Bewertung zusammen oder erwähne ein interessantes Detail', 'site-reviews' ),
		'prefix'      => false,
		'render'      => !in_array( 'title', $exclude ),
		'required'    => in_array( 'title', glsr_get_option( 'reviews-form.required', [] )),
		'suffix'      => $form_id,
		'value'       => $values['title'],
	]);

	echo $html->renderField([
		'type'        => 'textarea',
		'name'        => 'content',
		'errors'      => $errors,
		'label'       => __( 'Deine Bewertung', 'site-reviews' ),
		'placeholder' => __( 'Erkläre Deine Bewertung', 'site-reviews' ),
		'prefix'      => false,
		'rows'        => 5,
		'render'      => !in_array( 'content', $exclude ),
		'required'    => in_array( 'content', glsr_get_option( 'reviews-form.required', [] )),
		'suffix'      => $form_id,
		'value'       => $values['content'],
	]);

	echo $html->renderField([
		'type'        => 'text',
		'name'        => 'name',
		'errors'      => $errors,
		'label'       => __( 'Dein Name', 'site-reviews' ),
		'placeholder' => __( 'Sage uns Deinen Namen', 'site-reviews' ),
		'prefix'      => false,
		'render'      => !in_array( 'name', $exclude ),
		'required'    => in_array( 'name', glsr_get_option( 'reviews-form.required', [] )),
		'suffix'      => $form_id,
		'value'       => $values['name'],
	]);

	echo $html->renderField([
		'type'        => 'email',
		'name'        => 'email',
		'errors'      => $errors,
		'label'       => __( 'Deine E-Mail', 'site-reviews' ),
		'placeholder' => __( 'Sage uns Deine E-Mail', 'site-reviews' ),
		'prefix'      => false,
		'render'      => !in_array( 'email', $exclude ),
		'required'    => in_array( 'email', glsr_get_option( 'reviews-form.required', [] )),
		'suffix'      => $form_id,
		'value'       => $values['email'],
	]);

	echo $html->renderField([
		'type'       => 'checkbox',
		'name'       => 'terms',
		'errors'     => $errors,
		'options'    => __( 'Diese Bewertung basiert auf meiner eigenen Erfahrung und ist meine echte Meinung.', 'site-reviews' ),
		'prefix'     => false,
		'render'     => !in_array( 'terms', $exclude ),
		'required'   => true,
		'suffix'     => $form_id,
		'value'      => $values['terms'],
	]);

	echo $html->renderField([
		'type'   => 'hidden',
		'name'   => 'action',
		'prefix' => false,
		'value'  => 'post-review',
	]);

	echo $html->renderField([
		'type'   => 'hidden',
		'name'   => 'form_id',
		'prefix' => false,
		'value'  => $form_id,
	]);

	echo $html->renderField([
		'type'   => 'hidden',
		'name'   => 'assign_to',
		'prefix' => false,
		'value'  => $assign_to,
	]);

	echo $html->renderField([
		'type'   => 'hidden',
		'name'   => 'category',
		'prefix' => false,
		'value'  => $category,
	]);

	echo $html->renderField([
		'type'   => 'hidden',
		'name'   => 'excluded',
		'prefix' => false,
		'value'  => esc_attr( json_encode( $exclude )),
	]);

	wp_nonce_field( 'post-review' );

	if( $message ) {
		printf( '<div class="glsr-form-messages%s">%s</div>', ( $errors ? ' gslr-has-errors' : '' ), wpautop( $message ));
	}

	echo $html->renderField([
		'type'   => 'submit',
		'prefix' => false,
		'value'  => __( 'Gib uns Deine Bewertung', 'site-reviews' ),
	]);

?>
</form>
