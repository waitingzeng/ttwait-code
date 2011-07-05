/* 
	Eb163 Flash RPG Webgame Framework
	@author eb163.com
	@email game@eb163.com
	@website www.eb163.com
 */
package com.ttwait.worldedit.layers
{
	import com.ttwait.utils.MapEditorUtils;
	import com.ttwait.worldedit.data.WorldRooms;
	import com.ttwait.worldedit.items.Room;
	
	import flash.geom.Point;
	
	import mx.core.UIComponent;
	
	public class RoomLayer extends UIComponent
	{
		public var roomArray:Array;	//所有building数组，数组索引对应building id
		private var maxNum:int = 0;		//建筑数
		private var worldrooms:WorldRooms;
		
		public function RoomLayer(worldrooms:WorldRooms)
		{
			this.worldrooms = worldrooms;
			roomArray = new Array();
		}
		
		public function place(room:Room):void
		{
			this.roomArray[maxNum] = room;
			this.maxNum++;
		}
		
		
		private function placeSign(bld:Room, /*map:Maps,*/ tilePoint:Point):void
		{
			var tilePixelWidth:int = this.parentApplication._cellWidth;
			var tilePixelHeight:int = this.parentApplication._cellHeight;
			
			//阻挡和阴影标记
			var pt:Point = MapEditorUtils.getPixelPoint(tilePixelWidth, tilePixelHeight, tilePoint.x, tilePoint.y);
			//没有阻挡设置
			
			//var xpw:int = pt.x - int(bld..@xoffset) - tilePixelWidth/2;
			//var ypw:int = pt.y - int(bld.configXml.@yoffset) - tilePixelHeight/2;
	
			//_roadLayer.drawWalkableBuilding(bld, xpw, ypw, false);
			

		}
		//移除建筑
		public function removeBuild(bld:Room):void{
			var tilePixelWidth:int = this.parentApplication._cellWidth;
			var tilePixelHeight:int = this.parentApplication._cellHeight;
			var ct:Point = MapEditorUtils.getCellPoint(tilePixelWidth, tilePixelHeight,bld.x,bld.y);
			var pt:Point = MapEditorUtils.getPixelPoint(tilePixelWidth, tilePixelHeight, ct.x, ct.y);
			//var originPX:int = pt.x - int(bld.configXml.@xoffset);// - tilePixelWidth/2;
			//var originPY:int = pt.y - int(bld.configXml.@yoffset);// - tilePixelHeight/2;
			delete roomArray[bld.id];
			removeChild(bld);
		}
		
		//读取XML配置 放置建筑
		public function drawByConfig():void{
			
		}

	}
}