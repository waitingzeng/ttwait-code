/* 
	Eb163 Flash RPG Webgame Framework
	@author eb163.com
	@email game@eb163.com
	@website www.eb163.com
 */
package com.ttwait.utils
{
	
	import flash.display.BitmapData;
	import flash.display.Shape;
	import flash.geom.Point;
	
	public class MapEditorUtils
	{
		public function MapEditorUtils()
		{
		}
		
		 //根据屏幕象素坐标取得网格的坐标
		public static function getCellPoint(tileWidth:int, tileHeight:int, px:int, py:int):Point
		{
			var xtile:int = 0;	//网格的x坐标
			var ytile:int = 0;	//网格的y坐标
	
	        var cx:int, cy:int, rx:int, ry:int;
	        cx = int(px / tileWidth) * tileWidth + tileWidth/2;	//计算出当前X所在的以tileWidth为宽的矩形的中心的X坐标
	        cy = int(py / tileHeight) * tileHeight + tileHeight/2;//计算出当前Y所在的以tileHeight为高的矩形的中心的Y坐标
	
	        rx = (px - cx) * tileHeight/2;
	        ry = (py - cy) * tileWidth/2;
	
	        if (Math.abs(rx)+Math.abs(ry) <= tileWidth * tileHeight/4)
	        {
				//xtile = int(pixelPoint.x / tileWidth) * 2;
				xtile = int(px / tileWidth);
				ytile = int(py / tileHeight) * 2;
	        }
	        else
	        {
				px = px - tileWidth/2;
				//xtile = int(pixelPoint.x / tileWidth) * 2 + 1;
				xtile = int(px / tileWidth) + 1;
				
				py = py - tileHeight/2;
				ytile = int(py / tileHeight) * 2 + 1;
			}

			return new Point(xtile - (ytile&1), ytile);
		}
		
		// 根据网格坐标取得象素坐标
		public static function getPixelPoint(tileWidth:int, tileHeight:int, tx:int, ty:int):Point
		{
			//偶数行tile中心
			var tileCenter:int = (tx * tileWidth) + tileWidth/2;
			// x象素  如果为奇数行加半个宽
			var xPixel:int = tileCenter + (ty&1) * tileWidth/2;
			
			// y象素
			var yPixel:int = (ty + 1) * tileHeight/2;
			
			return new Point(xPixel, yPixel);
		}
		
		//得到建筑编辑器中的障碍
		public static function getWalkableSignMap(tilePixelWidth:int, tilePixelHeight:int):BitmapData
		{
			//菱形
			var shape:Shape = new Shape();
//			shape.graphics.beginFill(0xff0000,0.5);
//			shape.graphics.drawCircle(0,0,tilePixelHeight/4);
//			shape.graphics.endFill();
			//外框
			shape.graphics.lineStyle(1, 0xff0000, 0.6);
			shape.graphics.moveTo(0, tilePixelHeight/2);
			shape.graphics.lineTo(tilePixelWidth/2, 0);
			shape.graphics.lineTo(tilePixelWidth, tilePixelHeight/2);
			shape.graphics.lineTo(tilePixelWidth/2, tilePixelHeight);
			shape.graphics.lineTo(0, tilePixelHeight/2);
			//里框
			var hoff:Number = tilePixelHeight/4;
			var woff:Number = hoff * tilePixelWidth / tilePixelHeight;
			shape.graphics.moveTo(woff, tilePixelHeight/2);
			shape.graphics.lineTo(tilePixelWidth/2, hoff);
			shape.graphics.lineTo(tilePixelWidth-woff, tilePixelHeight/2);
			shape.graphics.lineTo(tilePixelWidth/2, tilePixelHeight-hoff);
			shape.graphics.lineTo(woff, tilePixelHeight/2);
			//交叉线
			shape.graphics.moveTo(0, tilePixelHeight/2);
			shape.graphics.lineTo(tilePixelWidth, tilePixelHeight/2);
			shape.graphics.moveTo(tilePixelWidth/2, 0);
			shape.graphics.lineTo(tilePixelWidth/2, tilePixelHeight);
			
			//保存到BitmapData
			var wb:BitmapData = new BitmapData(tilePixelWidth, tilePixelHeight, true, 0x00000000);
			wb.draw(shape);
			
			return wb;
		}
		

	}
}