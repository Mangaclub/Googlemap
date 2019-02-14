<?php
/*------------------------------------------------------------------------
# gmap - google map landkarten Component
# ------------------------------------------------------------------------
# author    Andy Thielke
# copyright Copyright (C) 2014. All Rights Reserved
# license   GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
# website   www.joomla.de.com
-------------------------------------------------------------------------*/

//-- No direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
jimport( 'joomla.html.pane' );

?>
  
<script type="text/javascript">
		
function insertText1(editor){
	// Artikel
	var map = $("as_map").value;
	var style1 = $("float").value;			
	var style2 = $("margin").value;
	var map_width = $("map_width").value;
	var map_height = $("map_height").value;
	var tag;
	if ($('iframe').checked){	
		tag = "<table style=\""+style1+style2+" width: "+map_width+"; height: "+map_height+";\"><tr><td style='width:100%; height:100%'><div class='gmap' id=\""+map+"\" style=\" background-image: url(components/com_gmap/assets/images/google_maps_logo.jpg); background-repeat: no-repeat; background-position: center center; width:100%; height:100%; border: 1px solid #000;\">{secureviewgm"+map+"}</div></td></tr></table>";	
	}else{
		tag = "<table style=\""+style1+style2+" width: "+map_width+"; height: "+map_height+";\"><tr><td width=100% height=100%><div class='gmap' id=\""+map+"\" style=\" background-image: url(components/com_gmap/assets/images/google_maps_logo.jpg); background-repeat: no-repeat; background-position: center center; width:100%; height:100%; border: 1px solid #000;\">{gm"+map+"}</div></td></tr></table>";	
	}
  window.parent.jInsertEditorText(tag,'<?php echo $this->eName;?>');
  window.parent.SqueezeBox.close();
  return false;
}
function insertText2(editor){
	// Artikel
	var link_map = $("as_link_map").value;
	var title = $("link_title").value;
	var subtitle = $("link_subtitle").value;
	var tag = "<a href=\"index.php?option=com_gmap&amp;view=gm_modal&amp;tmpl=component&amp;layout=default&amp;iframe=true&amp;map="+link_map+"\" title=\""+subtitle+"\" rel=\"example_group\">"+title+"</a>";	

  window.parent.jInsertEditorText(tag,'<?php echo $this->eName;?>');
  window.parent.SqueezeBox.close();
  return false;
}
function msgiframe(){
	var msg = 'Diese Option verwenden im Frontend die Karte nicht richtig dargestellt wird. \n';
		msg += 'Die Darstellung erfolgt dann durch ein iframe! \n';
		msg += 'Mit dem Standart Template "Protostar" \n\n';
		msg += 'Weitere Informationen finden Sie in der Dokumentation. \n ';
	alert(msg);	
}

</script>
  
  
  
  <style type="text/css">
  
div.current fieldset {
	border: 1px solid #CCC;
}
  </style>
<body>

<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'first')); ?>
<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'first',JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FIRST_PANEL'),true); ?>
<form id="form1" name="form1" method="post" action="">  
  <fieldset>
   <legend><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FIELDSET_SELECT_MAP' ); ?></legend>
     <table width="467" border="0" class="admintable">
    <tr>
      <td width="172" align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_SELECT_MAP' ); ?></td>
      <td width="176"><?php echo $this->map; ?></td>
      <td width="105">&nbsp;</td>
    </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FIELDSET_FORMAT_MAP' ); ?></legend>
    <table width="467" border="0">
      <tr>
        <td width="145" align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_FORMAT_MAP_POSITION' ); ?></td>
        <td ><select name="float" id="float">
          <option value="float: none;"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FORMAT_MAP_POSITION_OPTION_NO' ); ?></option>
          <option value="float: left;"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FORMAT_MAP_POSITION_OPTION_LEFT' ); ?></option>
          <option value="float: right;"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FORMAT_MAP_POSITION_OPTION_RIGHT' ); ?></option>
        </select></td>
      </tr>
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_MARGIN' ); ?></td>
        <td><select name="margin" id="margin">
          <option value="margin: 0px;">0</option>
          <option value="margin: 1px;">1</option>
          <option value="margin: 2px;">2</option>
          <option value="margin: 3px;">3</option>
          <option value="margin: 4px;">4</option>
          <option value="margin: 5px;" selected>5</option>
          <option value="margin: 6px;">6</option>
          <option value="margin: 7px;">7</option>
          <option value="margin: 8px;">8</option>
          <option value="margin: 9px;">9</option>
          <option value="margin: 10px;">10</option>
          </select> 
          px</td>
      </tr>
       <tr>
       <td align="right"  class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_MAP_WIDTH' ); ?></td>
			<td><input class="text_area" type="text" name="map_width" id="map_width" size="10" maxlength="10" value="80%" /></td>
	  </tr>
       <tr>
        <td  align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_MAP_HEIGHT' ); ?></td>
			<td width="245"><input class="text_area" type="text" name="map_height" id="map_height" size="10" maxlength="10" value="400px" /></td>
      </tr>
       <tr>
         <td  align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_SECURE_VIEW' ); ?></td>
         <td><input id="iframe" type="checkbox" value=""><button onClick="msgiframe();">Info</button></td>
       </tr>
    </table>
  </fieldset>
  </form>
  <button onClick="insertText1();"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_BUTTON_INSERT_MAP' ); ?></button>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'second', JText::_('PLG_EDITOR_BUTTON_VIEW_EDITOR_SECOND_PANEL', true)); ?>

<form id="form2" name="form2" method="post" action="">  
  <fieldset>
   <legend><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FIELDSET_SELECT_MAP' ); ?></legend>
     <table width="335" border="0">
    <tr>
      <td ><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_SELECT_MAP' ); ?></td>
      <td ><?php echo $this->link_map; ?></td>
    </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_FIELDSET_FORMAT_MAP' ); ?></legend>
    <table class="admintable" border="0">
      <tr>
        <td align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_MAP_LINK_SUBTITLE' ); ?></td>
		   <td ><textarea name="link_subtitle" cols="50" rows="7" class="text_area" id="link_subtitle"></textarea></td>
      </tr>
       <tr>
         <td align="right" class="key"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_LABEL_MAP_LINK_TITLE' ); ?></td>
         <td><input class="text_area" type="text" name="link_title" id="link_title" size="30" maxlength="100" value="<?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_VALUE_MAP_LINK_TITLE' ); ?>" /></td>
       </tr>
    </table>
  </fieldset>
  </form>
  <button onClick="insertText2();"><?php echo JText::_( 'PLG_EDITOR_BUTTON_VIEW_EDITOR_BUTTON_INSERT_MAP_LINK' ); ?></button>


<?php echo JHtml::_('bootstrap.endTab'); ?>
  </body>   
