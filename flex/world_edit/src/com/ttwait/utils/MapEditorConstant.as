/* 
	Eb163 Flash RPG Webgame Framework
	@author eb163.com
	@email game@eb163.com
	@website www.eb163.com
 */
package com.ttwait.utils
{
    import mx.binding.utils.BindingUtils;
    
	
	public class MapEditorConstant
	{
		public function MapEditorConstant()
		{
		}
		public static const SCALE:int = 10;
		
		//地图格类型 空白低点 最后会根据设置 转换为相应不可移动或者可移动区域
		public static const CELL_TYPE_SPACE:int = 0;
		
		public static const WORLD_WIDTH:int = 1400;
		
		public static const WORLD_HEIGHT:int = 800;
		
		//地图格类型 路点
		public static const CELL_TYPE_ROAD:int = 1;
		//地图格类型 障碍
		public static const CELL_TYPE_HINDER:int = 2;
		//保存时将空白区域转换为路点
		public static const TYPE_SAVE_MAP_ROAD:int = 0;
		//保存时将空白区域转换为障碍
		public static const TYPE_SAVE_MAP_HINDER:int = 1;

		//库图片路径
		public static const IMAGE_PATH:String = "images/";
		//地图图片路径
		public static const MAP_PATH:String = "maps/";
		//主路径
		public static const MAIN_PATH:String = "HFMapEdit/";
	}
}