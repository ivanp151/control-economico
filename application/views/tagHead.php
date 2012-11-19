<?php /* archivo de declaracion de variables a utilizar en javascript*/ ?>
<script type="text/javascript">
	var NAMEUSER = '<?=$this->session->userdata("name_user")?>'
    var SITEURL = '<?=SITEURL?>';
    var MEDIAURL = '<?=MEDIAURL?>';
    var LANGJAVASCRIPT = '<?=$this->lang->lang()?>';
</script>