<?php defined( 'WPINC' ) || die; ?>

<form method="post" action="">

	<?php
		echo $html->p( sprintf( _x( 'Alle hier gezeigten Daten und Zeiten verwenden die in WordPress %s.', 'konfigurierte Zeitzone', 'site-reviews' ),
			sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php' ), __( 'konfigurierte Zeitzone', 'site-reviews' ))
		));
	?>

	<table class="wp-list-table widefat fixed striped glsr-status">

		<thead>
			<tr>
				<th class="site"><?= __( 'Webseite', 'site-reviews' ); ?></th>
				<th class="total-fetched column-primary"><?= __( 'Bewertungen', 'site-reviews' ); ?></th>
				<th class="last-fetch"><?= __( 'Letzter Abruf', 'site-reviews' ); ?></th>
				<th class="next-fetch"><?= __( 'Nächster geplanter Abruf', 'site-reviews' ); ?></th>
			</tr>
		</thead>

		<tbody>

		<?php foreach( $tabs['settings']['sections'] as $key => $title ) : ?>

			<tr data-type="<?= $key; ?>">
				<td class="site">
					<a href="<?= admin_url( 'edit.php?post_type=site-review&page=' . glsr_app()->id . "&tab=settings&section={$key}" ); ?>"><?= $title; ?></a>
				</td>
				<td class="total-fetched column-primary">
					<a href="<?= admin_url( "edit.php?post_type=site-review&post_status=all&type={$key}" ); ?>"><?= $db->getReviewCount( 'type', $key ); ?></a>
					<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
				</td>
				<td class="last-fetch" data-colname="<?= __( 'Letzter Abruf', 'site-reviews' ); ?>">
					<?= $db->getOption( 'last_fetch.' . $key, __( 'Es wurde kein Abruf abgeschlossen', 'site-reviews' )); ?>
				</td>
				<td class="next-fetch" data-colname="<?= __( 'Nächster geplanter Abruf', 'site-reviews' ); ?>">
					<?= $db->getOption( 'next_fetch.' . $key, __( 'Derzeit ist nichts geplant', 'site-reviews' )); ?>
				</td>
			</tr>

		<?php endforeach; ?>

		</tbody>

	</table>

	<br>

	<hr>

	<table class="form-table">
		<tbody>

		<?php

			echo $html->row()->select( 'type', [
				'label'      => __( 'Bewertungen abrufen von', 'site-reviews' ),
				'options'    => $tabs['settings']['sections'],
				'attributes' => 'data-type',
				'prefix'     => glsr_app()->prefix,
			]);

			echo $html->row()->progress([
				'label'  => __( 'Status abrufen', 'site-reviews' ),
				'active' => __( 'Bewertungen abrufen...', 'site-reviews' ),
				'class'  => 'green',
			]);
		?>

		</tbody>
	</table>

	<?php wp_nonce_field( 'fetch-reviews' ); ?>

	<?php printf( '<input type="hidden" name="%s[action]" value="fetch-reviews">', glsr_app()->prefix ); ?>

	<?php submit_button( __( 'Bewertungen abrufen', 'site-reviews' ), 'große Primär', 'fetch-reviews' ); ?>

</form>
