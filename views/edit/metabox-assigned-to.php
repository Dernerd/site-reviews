<?php defined( 'WPINC' ) || die; ?>

<div class="glsr-search-box" id="glsr-search-posts">
	<span class="glsr-spinner"><span class="spinner"></span></span>
	<input type="hidden" id="assigned_to" name="assigned_to" value="<?= $id; ?>">
	<input type="search" class="glsr-search-input" autocomplete="off" placeholder="<?= __( 'Tippe um zu suchen...', 'site-reviews' ); ?>">
	<span class="glsr-search-results"></span>
	<p><?= __( 'Suche hier nach einer Seite oder einem Beitrag, dem Du diese Bewertung zuweisen möchtest. Du kannst nach Titel oder ID suchen.', 'site-reviews' ); ?></p>
	<span class="description"><?= $template; ?></span>
</div>

<script type="text/html" id="tmpl-glsr-assigned-post">
<?php include glsr_app()->path . 'views/edit/assigned-post.php'; ?>
</script>
