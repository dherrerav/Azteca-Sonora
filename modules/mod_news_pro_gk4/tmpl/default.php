<?php

/**
* Script template
* @package News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php if($this->config['useScript'] == 1) : ?><script type="text/javascript" src="<?php echo $uri->root(); ?>modules/mod_news_pro_gk4/interface/scripts/engine.js"></script><?php endif; ?>
<script type="text/javascript">
//<![CDATA[
try {$Gavick;}catch(e){$Gavick = {};};
$Gavick["nsp-<?php echo $this->config['module_id'];?>"] = {
	"animation_speed": <?php echo $this->config['animation_speed']; ?>,
	"animation_interval": <?php echo $this->config['animation_interval']; ?>,
	"animation_function": <?php echo $this->config['animation_function']; ?>,
	"news_column": <?php echo $this->config['news_column']; ?>,
	"news_rows": <?php echo $this->config['news_rows']; ?>,
	"links_columns_amount": <?php echo $this->config['links_columns_amount']; ?>,
	"links_amount": <?php echo $this->config['links_amount']; ?>,
	"counter_text": '<?php echo $this->config['counter_text']; ?>'
};
//]]>
</script>	