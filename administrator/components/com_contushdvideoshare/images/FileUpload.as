/**
 * @version		$Id: FileUpload.as 1.0 2009-09-19 $
 * @package		Joomla
 * @subpackage	hdflvplayer
 * @copyright	Copyright (C) 2008 - 2009 Contus Support BPO Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 */

package {
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.external.ExternalInterface;
	import flash.events.*;
	import flash.net.*;
	import fl.controls.Button;
	import flash.ui.ContextMenu;

	public class FileUpload extends Sprite 
	{
		private var my_menu:ContextMenu = new ContextMenu();
		private var _fileReference:FileReference;
		private var browseButton:Button = new Button();
		private var flashvars:Number = 1;
		private var uploadsize:Number = 100 * 1024;
		
    	public function FileUpload() 
		{			
		    flashvars = root.loaderInfo.parameters.value;
		    uploadsize = root.loaderInfo.parameters.uploadsize;
			
    		my_menu.hideBuiltInItems();
			contextMenu = my_menu;
			progress_display.visible = false;
			
			browseButton.move(10, 10);
			browseButton.buttonMode = true;
			if (flashvars == 1 || flashvars == 4) browseButton.label = "Upload a Video"; else  browseButton.label = "Upload an Image";
			browseButton.addEventListener(MouseEvent.CLICK, browseHandler);
			addChild(browseButton);
			
			_fileReference = new FileReference();
			_fileReference.addEventListener(Event.SELECT, selectHandler);
			_fileReference.addEventListener(Event.CANCEL, cancelHandler);
			_fileReference.addEventListener(ProgressEvent.PROGRESS,progressHandler);
			_fileReference.addEventListener(IOErrorEvent.IO_ERROR,ioErrorHandler);
			_fileReference.addEventListener(SecurityErrorEvent.SECURITY_ERROR,securityHandler);
			_fileReference.addEventListener(Event.COMPLETE, completeHandler);
		}
		
		private function browseHandler(event:MouseEvent):void 
		{
			if(flashvars == 1 || flashvars == 4)
    		 _fileReference.browse( [ new FileFilter("Videos", "*.wmv;*.avi;*.divx;*.3gp;*.mov;*.mpeg;*.mpg;*.xvid;*.flv;*.asf;*.rm;*.dat;*.mp4")] );
			else 
			 _fileReference.browse( [ new FileFilter("Images", "*.jpg;*.gif;*.png;*.jpeg")] );
			
		}
		
		private function selectHandler(event:Event):void 
		{
			if(_fileReference.size / (1024 * 1024) > uploadsize)
			ExternalInterface.call("alert","File size exceed");
			else
			{
			ExternalInterface.call("getvideo", "1", flashvars); uploadHandler(); 
			}
		}
		
		private function cancelHandler(event:Event):void 
		{
            browseButton.visible = true;
			progress_display.visible = false;
			_fileReference.cancel();
		}
		
		private function uploadHandler():void 
		{
			_fileReference.upload(new URLRequest("simpleFileUpload.php"));
		}
		
		private function progressHandler(event:ProgressEvent):void 
		{
			browseButton.visible = false;
			progress_display.visible = true;
			if((event.bytesLoaded /  event.bytesTotal) <= 0.1) progress_display.loader.pro.scaleX = (event.bytesLoaded /  event.bytesTotal);
			else progress_display.loader.pro.scaleX = (event.bytesLoaded /  event.bytesTotal) - 0.02;
			progress_display.Cancel.addEventListener(MouseEvent.CLICK,  cancelHandler);
			progress_display.Cancel.buttonMode = true;
		}
		
		private function ioErrorHandler(event:IOErrorEvent):void 
		{
			trace("an IO error occurred");
		}
		
		private function securityHandler(event:SecurityErrorEvent):void 
		{
			trace("a security error occurred");
		}
		
		private function completeHandler(event:Event):void 
		{
			progress_display.loader.pro.scaleX = 1;
			browseButton.visible = true;
			progress_display.visible = false;
			ExternalInterface.call("getvideo",_fileReference.name, flashvars);
		}
		
	}
}