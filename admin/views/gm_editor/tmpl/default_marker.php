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
?>
<div id="tab-2">
<div class="subhead">
<div id="toolbar" class="btn-toolbar">
<div id="toolbar-save" class="btn-wrapper">
	<a class="btn btn-small" onclick="newmarker()" href="#">
	<span class="icon-plus-2"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_NEW' ); ?>
    </a>
    <a class="btn btn-small" onclick="Marker.delete()" href="#">
	<span class="icon-delete"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_DELETE' ); ?>
    </a>
    <div class="btn-wrapper" style="width:170px"><?php echo $this->form->getInput('marker_access_level'); ?></div>
    </div>
<div id="toolbar-help" class="btn-wrapper">    
	<a class="modal-button btn btn-small" href=<?php echo $this->config->help_marker?>>
    <span class="icon-question-sign"></span>
	<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_BUTTON_HELP' ); ?>
    </a>
</div>
</div>
</div>
	<ul id="marker-tab" class="nav nav-tabs" role="tablist" style="margin-bottom: 5px;">
		<li class="active">
  			<a href="#marker-page-1" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MARKEREDIT' ); ?></a>
		</li>
		<li>
  			<a href="#marker-page-2" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_MARKERINFOWINDOWEDITOR' ); ?></a>
		</li>
		<li>
  			<a href="#marker-page-3" role="tab" data-toggle="tab"><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_INFOWINDOW_OPTION' ); ?></a>
		</li>
		<li>
  			<a onClick="initmarkertabelle()" href="#marker-page-4" role="tab" data-toggle="tab">
			<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_SUBTAB_TABLE_MARKER' ); ?></a>
		</li>
		<li>
  			<a href="#marker-page-5" role="tab" data-toggle="tab"><?php echo JText::_( 'Cluster' ); ?></a>
		</li>
    </ul>

<div class="tab-content">
<div class="tab-pane active" id="marker-page-1">
<table class="admintable"   border="0">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('marker_autocomplete_section'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_autocomplete_section'); ?>
      
      </br>
	<div id="marker_address">
	  <?php echo $this->form->getInput('marker_address'); ?>
		<a class="btn btn-small" onclick="Marker.moveToAddress()" href="#">
       	 <img src="components/com_gmap/assets/images/refresh.png" alt="" width="16" height="16" class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_MOVE_MARKER' ); ?>" />
		</a>
    </div>
	<div id="marker_move_lat_lng">
	  <?php echo $this->form->getInput('move_lat'); ?>
   	  <?php echo $this->form->getInput('move_lng'); ?>
		<a class="btn btn-small" onclick="Marker.moveToLatLng()" href="#">
       	 <img src="components/com_gmap/assets/images/refresh.png" alt="" width="16" height="16" class="assume" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_MOVE_MARKER' ); ?>" />
		</a>
    </div>
      
      </td>
      <td>
       </td>
      <td rowspan="10" valign="top" ><?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_LABEL_ICON' ); ?>
        <div id="markerList" >
          <div class="markericonstandard btn btn-small" onclick="Marker.setIcon('standard','standard')"> <img class="markericon" id="standard"  src="components/com_gmap/assets/images/pin_rot.png" /><br />
            <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_LABEL_ICON_STANDARD' ); ?> </div>
          <div class="selectedmarker">
            <script language="JavaScript" type="text/javascript">
							jsimg='components/com_gmap/assets/images/pin_rot.png';
						document.write('<img src=' + jsimg + ' name="imagelib"  border="2" alt="" />');
						</script>
            <br />
            <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_LABEL_ICON_PREVIEW', true ); ?> </div>
          <div class="clr"></div>
          <div id="markericontreeview" class="css-treeview">
            <?php
                $folderList = JFolder::folders('../images/stories/com_gmap/');
                    if ($folderList !== false) {
                        foreach ($folderList as $folder){
            ?>
            <li>
              <input type="checkbox" id="<?php echo $folder; ?>" />
              <label for="<?php echo $folder; ?>2">
                <?php
              $sys_folder = (explode('_', $folder, 2));
              if ($sys_folder[0] == 'gm') {
              echo JText::_('COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_ICON_FOLDER_'.strtoupper($folder));
              }else{
                 echo JText::_($folder);  
              }
              ?>
              </label>
              <ul>
                <?php
                $fileList = JFolder::files('../images/stories/com_gmap/'.$folder.'/');
                    if ($fileList !== false) {
                        foreach ($fileList as $file){
            ?>
                <img title="<?php echo $file;?>" class="markericon" id="<?php echo $file; ?>" onclick="Marker.setIcon('<?php echo $folder; ?>','<?php echo $file; ?>')" src="<?php echo JURI::root(true).'/images/stories/com_gmap/'.$folder.'/'.$file;?>" />
                <?php }} ?>
              </ul>
            </li>
            <?php }} ?>
          </div>
          <p>&nbsp;</p>
        </div></td>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('marker_titel'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_titel'); ?></td>
      <td></td>
      </tr>
	<tr class="gm_row1">
	  <td class="control-label gm_row0"><?php echo $this->form->getLabel('marker_strasse'); ?></td>
	  <td class="controls gm_row0"><?php echo $this->form->getInput('marker_strasse'); ?></td>
	  <td></td>
	  </tr>
    <tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('marker_plz'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_plz'); ?></td>
      <td></td>
      </tr>
	<tr class="gm_row0">
      <td class="control-label"><?php echo $this->form->getLabel('marker_ort'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_ort'); ?></td>
      <td></td>
      </tr>
	<tr>
	 	<td>&nbsp;</td>
		<td ><input class="button" id="button_beschreibung" name="button" type="button" onclick="Marker.createText();" value="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_MOVE_FIELDS' ); ?> " /></td>
        <td></td>
        </tr>
	<tr class="gm_row1">
	  <td class="control-label"><?php echo $this->form->getLabel('marker_mouseover'); ?></td>
	  <td nowrap="nowrap" class="controls"><?php echo $this->form->getInput('marker_mouseover'); ?>
	    <a  href="javascript:void(0)" onclick="Marker.createMouseOver();" >
	      <img class="markerassume" src="components/com_gmap/assets/images/assume.png" width="11" title="<?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_BUTTON_SETMOUSEOVERTEXT' ); ?>" height="11"  /></a> 
	    </td>
	  <td></td>
	  </tr>
	</table>
</div>
<div class="tab-pane" id="marker-page-2">
    <div class="btn-wrapper" >
        <a class="btn btn-small" onclick="Marker.setText()" href="#">
        <img class="assume" src="components/com_gmap/assets/images/assume_editor.png" width="16" height="16" />
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_ASSUME' ); ?>
        </a>
        <a class="btn btn-small" onclick="Marker.deleteText()" href="#">
        <img class="assume" src="components/com_gmap/assets/images/editor_new.png" width="16" height="16" />
        <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_LINE_BUTTON_EDITOR_DELETE' ); ?>
        </a>
        <?php //echo $this->form->getInput('marker_language'); ?>
    </div>
    <div class="controls"><?php echo $this->form->getInput('marker_beschreibung'); ?></div>
</div>
<div class="tab-pane" id="marker-page-3">
  <table class="admintable">
	<tr class="gm_row1">
      <td class="control-label"><?php echo $this->form->getLabel('marker_infowindow_open'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_infowindow_open'); ?></td>
	</tr>
    </table>
</div>
<div class="tab-pane" id="marker-page-4">
  <div class="subtabelle" id="page_markertabelle"></div>
</div>
<div class="tab-pane" id="marker-page-5">
<table width="100%" border="0">
  <tr class="gm_row1" height="36px">
      <td class="control-label"><?php echo $this->form->getLabel('marker_cluster_activ'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_cluster_activ'); ?></td>
    <td rowspan="5" valign="top">
            <div id="Clustericontreeview" >
            <?php echo JText::_( 'COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_CLUSTER_LABEL_ICON' ); ?>
            <div class="css-treeview">
             <?php
                $folderList = JFolder::folders('../plugins/content/plg_content_gmap/assets/gm_cluster/');
                    if ($folderList !== false) {
                        foreach ($folderList as $folder){
            ?>
              <li><input type="checkbox" id="<?php echo $folder; ?>" /><label for="<?php echo $folder; ?>">
              <?php
              $sys_folder = (explode('_', $folder, 2));
              if ($sys_folder[0] == 'gm') {
              echo JText::_('COM_GMAP_VIEW_GM_MAP_EDITOR_MARKER_CLUSTER_ICON_FOLDER_'.strtoupper($folder));
              }else{
                 echo JText::_($folder);  
              }
              ?></label>
                <ul>
              <?php
                $fileList = JFolder::files('../plugins/content/plg_content_gmap/assets/gm_cluster/'.$folder.'/');
                    if ($fileList !== false) {
                        foreach ($fileList as $file){
            ?>
                  <img title="<?php echo $file;?>" class="markericon" id="<?php echo $file; ?>" 
                  onclick="controlerMarkerCluster.setClusterIcon('<?php echo $folder; ?>','<?php echo $file; ?>')" 
                  src="<?php echo JURI::root(true).'/plugins/content/plg_content_gmap/assets/gm_cluster/'.$folder.'/'.$file;?>" />
                  
                  <?php }} ?> 
                  </ul>
                </li>
              <?php }} ?>
            </div>          
            </div>
    </td>
  </tr>
  <tr class="gm_row0" height="36px">
      <td class="control-label"><?php echo $this->form->getLabel('marker_cluster_grid_size'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_cluster_grid_size'); ?></td>
    </tr>
  <tr class="gm_row1" height="36px">
      <td class="control-label"><?php echo $this->form->getLabel('marker_cluster_info_window'); ?></td>
      <td class="controls"><?php echo $this->form->getInput('marker_cluster_info_window'); ?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>

</div>

</div>
</div>
<?php echo $this->form->getInput('map_folder_cluster_icon'); ?>
<?php echo $this->form->getInput('map_cluster_icon'); ?>
<input type="hidden" id ="idlastmarker" name="idlastmarker" value="" />	
<input type="hidden" id ="activmarker" name="activmarker" value="" />		
