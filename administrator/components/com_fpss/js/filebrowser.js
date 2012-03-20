/**
 * @version		$Id: filebrowser.js 636 2011-08-14 07:28:34Z joomlaworks $
 * @package		Frontpage Slideshow
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		Commercial - This code cannot be redistributed without permission from JoomlaWorks Ltd.
 */

var ImageManager = {

	initialize: function() {
		this.upbutton = $('folderUpButton');
		this.upbutton.removeEvents('click');
		this.upbutton.addEvent('click', function() {
			ImageManager.upFolder();
		});
	},

	upFolder: function() {
		folder = frames['filebrowser'].location.href.split('&folder=');
		if(folder.length < 2){
			return;
		}
		path = folder.getLast();
		tmp = path.split('&');
		path = tmp[0];
		folders = path.split('/');
		if(folders.length < 2){
			frames['filebrowser'].location = 'index.php?option=com_media&view=imagesList&tmpl=component';
		}
		else {
			frames['filebrowser'].location = 'index.php?option=com_media&view=imagesList&tmpl=component&folder='+folders[folders.length-2];
		}
	},

	populateFields: function(file) {
		var browseButton = window.parent.$FPSS('#'+elementID);

		browseButton.parent().parent().get(0).reset();
		browseButton.val(imagePath+file);
		browseButton.parent().next().attr('src', 'components/com_fpss/images/loading.gif');
		window.parent.resizeElement(browseButton.parent().next(),100,100);
		browseButton.parent().parent().submit();
		window.parent.closeModal();
	}

};

$FPSS(document).ready(function(){
	ImageManager.initialize();
	$FPSS('#filebrowser').load(function(){
		folder = frames['filebrowser'].location.href.split('&folder=');
		if(folder.length >1){
			path = folder.getLast();
			tmp = path.split('&');
			path = tmp[0];
			$FPSS('#addressPath').val(imagePath+path);
		}
		else {
			$FPSS('#addressPath').val(imagePath);
		}
	});
});
