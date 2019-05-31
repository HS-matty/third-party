<?php

(defined('_VALID_MOS') OR defined('_JEXEC')) or die;
$doc= JFactory::getDocument();
$doc->addScript(JURI::base().'templates/portal/js/comments.js');

/*
*
* Comments form template
*
*/
class jtt_tpl_form extends JoomlaTuneTemplate
{
	function render()
	{

		if ($this->getVar('comments-form-link', 0) == 1) {
			$this->getCommentsFormLink();
			return;
		}

		$this->getCommentsFormFull();

        if ($this->getVar('comments-form-message', 0) == 1) {
            $this->getMessage( $this->getVar('comments-form-message-text') );
            return;
        }
	}

	/*
	 *
	 * Displays full comments form (with smiles, bbcodes and other stuff)
	 *
	 */
	function getCommentsFormFull()
	{
		$object_id = $this->getVar('comment-object_id');
		$object_group = $this->getVar('comment-object_group');

		$htmlBeforeForm = $this->getVar('comments-form-html-before');
		$htmlAfterForm = $this->getVar('comments-form-html-after');
?>
<?php
		if ($this->getVar( 'comments-form-policy', 0) == 1) {
?>
<div class="comments-policy"><?php echo $this->getVar( 'comments-policy' ); ?></div>
<?php
		}
?>
<?php echo $htmlBeforeForm; ?>
<!--<a id="addcomments" href="#addcomments"></a>-->
<form id="comments-form" name="comments-form" action="javascript:void(null);">
<?php
		if ($this->getVar( 'comments-form-user-name', 1) == 1) {
			$text = ($this->getVar('comments-form-user-name-required', 1) == 0) ? JText::_('FORM_NAME') : JText::_('FORM_NAME_REQUIRED');
?>
	<span class="comment_field name">
		<input id="comments-form-name" type="text" name="name" value="" placeholder="<?php echo $text ?>" maxlength="<?php echo $this->getVar('comment-name-maxlength');?>" size="22" tabindex="1" />

	</span>
<?php
		}
		if ($this->getVar( 'comments-form-user-email', 1) == 1) {
			$text = ($this->getVar('comments-form-email-required', 1) == 0) ? JText::_('FORM_EMAIL') : JText::_('FORM_EMAIL_REQUIRED');
?>
	<span class="comment_field email">
		<input id="comments-form-email" type="text" name="email" placeholder="<?php echo $text ?>" value="" size="22" tabindex="2" />
	</span>
	

<?php
	// update by matt1 10.07.2013
	}
	if($this->_globals['thisurl'] == '/reviews'){ 
		if ($this->getVar( 'comments-form-user-position', 1) == 1) {
			$text = ($this->getVar('comments-form-position-required', 0) == 0) ? JText::_('FORM_POSITION') : JText::_('FORM_POSITION_REQUIRED');
?>
	<span class="comment_field position">
		<input id="comments-form-position" type="text" name="position" placeholder="<?php echo $text ?>" value="" size="22" tabindex="2" />
	</span>
	<?php } //end of update?>




	
	
<?php
		}
		if ($this->getVar('comments-form-user-homepage', 0) == 1) {
			$text = ($this->getVar('comments-form-homepage-required', 1) == 0) ? JText::_('FORM_HOMEPAGE') : JText::_('FORM_HOMEPAGE_REQUIRED');
?>
	<span class="comment_field homepage">
		<input id="comments-form-homepage" type="text" name="homepage" value="" size="22" tabindex="3" />
		<label for="comments-form-homepage"><?php echo $text; ?></label>
	</span>
<?php
		}
		if ($this->getVar('comments-form-title', 0) == 1) {
			$text = ($this->getVar('comments-form-title-required', 1) == 0) ? JText::_('FORM_TITLE') : JText::_('FORM_TITLE_REQUIRED');
?>
	<span>
		<input id="comments-form-title" type="text" name="title" value="" size="22" tabindex="4" />
		<label for="comments-form-title"><?php echo $text; ?></label>
	</span>
<?php
		}
?>

		<textarea id="comments-form-comment" name="comment" tabindex="5"></textarea>

<?php
		if ($this->getVar('comments-form-subscribe', 0) == 1) {
?>
	<span class="comment_field subscribe">
		<input class="checkbox" id="comments-form-subscribe" type="checkbox" name="subscribe" value="1" tabindex="5" />
		<label for="comments-form-subscribe"><?php echo JText::_('FORM_SUBSCRIBE'); ?></label><br />
	</span>
<?php
		}

		if ($this->getVar('comments-form-captcha', 0) == 1) {
			$html = $this->getVar('comments-form-captcha-html');
			if ($html != '') {
				echo $html;
			} else {
				$link = JCommentsFactory::getLink('captcha');
?>
	<span class="field_captcha">
        <div class="captcha_img">
            <img class="captcha" onclick="jcomments.clear('captcha');" id="comments-form-captcha-image" src="<?php echo $link; ?>" width="121" height="60" alt="<?php echo JText::_('FORM_CAPTCHA'); ?>" />
        </div>
		<div class="captcha_info">
            <span class="captcha" onclick="jcomments.clear('captcha');"><?php echo JText::_('FORM_CAPTCHA_REFRESH'); ?></span>
            <input class="captcha" id="comments-form-captcha" type="text" name="captcha_refid" value="" size="5" placeholder="Код" tabindex="6" />
        </div>
	</span>
<?php
			}
		}
?>
<div id="comments-form-buttons">
	<div class="btn" id="comments-form-send"><a tabindex="7" onclick="jcomments.saveComment();return false;" title="<?php echo JText::_('FORM_SEND_HINT'); ?>"><?php echo JText::_('COMMENT_FORM_SEND'); ?></a></div>
	<div class="btn" id="comments-form-cancel" style="display:none;"><a tabindex="8" onclick="return false;" title="<?php echo JText::_('FORM_CANCEL'); ?>"><?php echo JText::_('FORM_CANCEL'); ?></a></div>
</div>
<div>
	<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
	<input type="hidden" name="object_group" value="<?php echo $object_group; ?>" />
</div>
</form>
<script type="text/javascript">
<!--
function JCommentsInitializeForm()
{
	var jcEditor = new JCommentsEditor('comments-form-comment', true);
<?php
		if ($this->getVar('comments-form-bbcode', 0) == 1) {
			$bbcodes = array( 'b'=> array(0 => JText::_('FORM_BBCODE_B'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT'))
					, 'i'=> array(0 => JText::_('FORM_BBCODE_I'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT'))
					, 'u'=> array(0 => JText::_('FORM_BBCODE_U'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT'))
					, 's'=> array(0 => JText::_('FORM_BBCODE_S'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT'))
					, 'img'=> array(0 => JText::_('FORM_BBCODE_IMG'), 1 => JText::_('BBCODE_HINT_ENTER_FULL_URL_TO_THE_IMAGE'))
					, 'url'=> array(0 => JText::_('FORM_BBCODE_URL'), 1 => JText::_('BBCODE_HINT_ENTER_FULL_URL'))
					, 'hide'=> array(0 => JText::_('FORM_BBCODE_HIDE'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT_TO_HIDE_IT_FROM_UNREGISTERED'))
					, 'quote'=> array(0 => JText::_('FORM_BBCODE_QUOTE'), 1 => JText::_('BBCODE_HINT_ENTER_TEXT_TO_QUOTE'))
					, 'list'=> array(0 => JText::_('FORM_BBCODE_LIST'), 1 => JText::_('BBCODE_HINT_ENTER_LIST_ITEM_TEXT'))
					);

			foreach($bbcodes as $k=>$v) {
				if ($this->getVar('comments-form-bbcode-' . $k , 0) == 1) {
					$title = trim(JCommentsText::jsEscape($v[0]));
					$text = trim(JCommentsText::jsEscape($v[1]));
?>
	jcEditor.addButton('<?php echo $k; ?>','<?php echo $title; ?>','<?php echo $text; ?>');
<?php
				}
			}
		}

		$customBBCodes = $this->getVar('comments-form-custombbcodes');
		if (count($customBBCodes)) {
			foreach($customBBCodes as $code) {
				if ($code->button_enabled) {
					$k = 'custombbcode' . $code->id;
					$title = trim(JCommentsText::jsEscape($code->button_title));
					$text = empty($code->button_prompt) ? JText::_('BBCODE_HINT_ENTER_TEXT') : JText::_($code->button_prompt);
					$open_tag = $code->button_open_tag;
					$close_tag = $code->button_close_tag;
					$icon = $code->button_image;
					$css = $code->button_css;
?>
	jcEditor.addButton('<?php echo $k; ?>','<?php echo $title; ?>','<?php echo $text; ?>','<?php echo $open_tag; ?>','<?php echo $close_tag; ?>','<?php echo $css; ?>','<?php echo $icon; ?>');
<?php
				}
			}
		}

		$smiles = $this->getVar( 'comment-form-smiles' );

		if (isset($smiles)) {
			if (is_array($smiles)&&count($smiles) > 0) {
?>
	jcEditor.initSmiles('<?php echo $this->getVar( "smilesurl" ); ?>');
<?php
				foreach ($smiles as $code => $icon) {
					$code = trim(JCommentsText::jsEscape($code));
					$icon = trim(JCommentsText::jsEscape($icon));
?>
	jcEditor.addSmile('<?php echo $code; ?>','<?php echo $icon; ?>');
<?php
				}
			}
		}
		if ($this->getVar( 'comments-form-showlength-counter', 0) == 1) {
?>
	jcEditor.addCounter(<?php echo $this->getVar('comment-maxlength'); ?>, '<?php echo JText::_('FORM_CHARSLEFT_PREFIX'); ?>', '<?php echo JText::_('FORM_CHARSLEFT_SUFFIX'); ?>', 'counter');
<?php
		}
?>
    jcomments.setForm(new JCommentsForm('comments-form', jcEditor));
}

<?php
	if ($this->getVar('comments-form-ajax', 0) == 1) {
?>
setTimeout(JCommentsInitializeForm, 100);
<?php
	} else {
?>
if (window.addEventListener) {window.addEventListener('load',JCommentsInitializeForm,false);}
else if (document.addEventListener){document.addEventListener('load',JCommentsInitializeForm,false);}
else if (window.attachEvent){window.attachEvent('onload',JCommentsInitializeForm);}
else {if (typeof window.onload=='function'){var oldload=window.onload;window.onload=function(){oldload();JCommentsInitializeForm();}} else window.onload=JCommentsInitializeForm;}
<?php
	}
?>
//-->
</script>
<?php echo $htmlAfterForm; ?>
<?php
	}

	/*
	 *
	 * Displays link to show comments form
	 *
	 */
	function getCommentsFormLink()
	{
		$object_id = $this->getVar('comment-object_id');
		$object_group = $this->getVar('comment-object_group');
?>
<div id="comments-form-link">
<a id="addcomments" class="showform" href="#addcomments" onclick="jcomments.showForm(<?php echo $object_id; ?>,'<?php echo $object_group; ?>', 'comments-form-link'); return false;"><?php echo JText::_('FORM_HEADER'); ?></a>
</div>
<?php
	}

	/*
	 *
	 * Displays service message
	 *
	 */
	function getMessage( $text )
	{
		if ($text != '') {
?>

<a id="addcomments" href="#addcomments"></a>
<p class="message"><?php echo $text; ?></p>
<?php
		}
	}
}
?>