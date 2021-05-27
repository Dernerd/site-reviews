<?php defined( 'WPINC' ) || die; ?>

<div class="glsr-search-box" id="glsr-search-translations">
	<span class="screen-reader-text"><?= __( 'Suche nach übersetzbarem Text', 'site-reviews' ); ?></span>
	<div class="glsr-spinner"><span class="spinner"></span></div>
	<input type="search" class="glsr-search-input" autocomplete="off" placeholder="<?= __( 'Suche nach übersetzbarem Text...', 'site-reviews' ); ?>">
	<div class="glsr-search-results" data-prefix="<?= $db->getOptionName(); ?>"></div>
</div>

<?= $html->renderForm( "{$tabView}/{$tabViewSection}" ); ?>

<script type="text/html" id="tmpl-glsr-string-plural">
<?php include glsr_app()->path . 'views/strings/plural.php'; ?>
</script>
<script type="text/html" id="tmpl-glsr-string-single">
<?php include glsr_app()->path . 'views/strings/single.php'; ?>
</script>
