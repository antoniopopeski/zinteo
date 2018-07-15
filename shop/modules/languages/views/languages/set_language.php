<?php 
$current_language = get_language();
?>

	<a class="pointer" <?php echo ($current_language == 'en') ? "style='color:#f09f1e !important'" : ""?> onclick="setLanguage('en')">EN</a>
	<a class="pointer" <?php echo ($current_language == 'de') ? "style='color:#f09f1e !important'" : ""?> onclick="setLanguage('de')">DE</a>
	<a class="pointer" <?php echo ($current_language == 'pl') ? "style='color:#f09f1e !important'" : ""?> onclick="setLanguage('pl')">PL</a>

<style type="text/css">
	.pointer{cursor: pointer;}
</style>

<script type="text/javascript">
function setLanguage(lang){
	document.language.lang.value=lang;
	document.language.submit();
}
</script>
<form name="language" id="language" method="post"
	action="<?php echo base_url()?>/languages/languages/set_language">
	<input type="hidden" value="" name="lang" id="lang" />
</form>