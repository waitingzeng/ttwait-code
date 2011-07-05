package com.ttwait.network{
	
	import com.adobe.serialization.json.JSON;
	
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	import flash.net.navigateToURL;
	
	import mx.controls.Alert;
	
	
	public class Network extends Sprite implements IEventDispatcher
	{
		private static var loader:URLLoader;

		
		
		public function Network()
		{
			
		}
		
		public static function getUrl(urlPath:String, data:URLVariables, responseHandler:Function):void
		{
			var req:URLRequest = new URLRequest(Configuration.getUrl(urlPath));
			if(data){
				req.data = data;
                req.method = URLRequestMethod.POST;
                
			}
			var loader:URLLoader = new URLLoader(req);
	        
			trace(req.url, '....', req.data);
			loader.addEventListener(IOErrorEvent.IO_ERROR, errorLoadUrlHandler);
			loader.addEventListener(Event.COMPLETE, function(event:Event):void{
				responseHandler(loader.data);
			});
		}
		
		public static function getJSON(urlPath:String, data:URLVariables, responseHandler:Function):void
		{
			getUrl(urlPath, data, function(data:String):void{
				var json_data:Object = JSON.decode(data);
				responseHandler(json_data);
			})
		}
		
		public static function getXML(urlPath:String, data:URLVariables, responseHandler:Function):void{
			getUrl(urlPath, data, function(data:String):void{
				responseHandler(XML(data));
			})
		}
		
		private static function errorLoadUrlHandler(e:Event):void
		{
			trace("Download config files failure...", e.toString());
            Alert.show(e.toString() + " Error");
		}
	}
}
