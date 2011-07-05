package
{

	import flash.utils.Dictionary;
	import flash.xml.XMLNode;
    import mx.managers.IBrowserManager;
    import mx.managers.BrowserManager;
    import mx.utils.URLUtil;
    

	public class Configuration
	{

		public static var webhost:String = '';

		public function Configuration()
		{
		}

    
		public static function getUrl(urlPath:String):String
		{
			return webhost + urlPath;
		}
	}
}