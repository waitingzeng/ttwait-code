
//新建类LinkMap.as  用于画图标

package com
	
{
	
	import flash.events.MouseEvent;
	
	import flash.geom.Point;
	
	import flash.net.SharedObject;
	
	
	
	import mx.containers.Canvas;
	
	import mx.controls.Image;
	
	import mx.controls.Label;
	
	
	
	public class LinkMap extends Canvas
		
	{
		
		private var oldIndex:int;
		
		private var lineList:Array = new Array();
		
		private var num:int = 0;
		
		public var startDrawClick:Boolean;
		
		public var endDrawClick:Boolean;
		
		
		
		public function LinkMap(point:Point, width:Number,height:Number,name:String,type:int)
			
		{
			
			super();
			
			this.x = point.x;
			
			this.y = point.y;
			
			this.width = width;
			
			this.height = height;
			
			
			
			
			
			this.init(name,type);
			
		}
		
		private function init(name:String,type:int):void{
			
			this.addEventListener(MouseEvent.MOUSE_DOWN,onMouseDown);
			
			this.addEventListener(MouseEvent.MOUSE_MOVE,onMouseMove);
			
			this.addEventListener(MouseEvent.MOUSE_UP,onMouseUp);
			
			// 设置没有滚动条
			
			this.verticalScrollPolicy = "off";
			
			this.horizontalScrollPolicy = "off";
			
			
			
			var uLable:Label = new Label();
			
			uLable.text = name;
			
			uLable.x = 0 ;
			
			uLable.y = 60;
			
			uLable.width = 30;
			
			uLable.height =60;
			
			this.addChild(uLable);
			
			
			
			var uImage:Image = new Image();
			
			switch(type){
				
				case 1:
					
					uImage.source = "image/client.png";
					
					break;
				
				case 2:
					
					uImage.source = "image/server.png";
					
			}
			
			uImage.x = 10;
			
			uImage.y = 0;
			
			
			
			this.addChild(uImage);
			
		}
		
		
		
		private function onMouseDown(event:MouseEvent):void{
			
			//设置移动的图标所处的层次
			
			oldIndex = this.parent.getChildIndex(this);
			
			this.parent.setChildIndex(this,this.parent.numChildren-1);
			
			
			
			//设置全局变量
			
			var shareObject:SharedObject = SharedObject.getLocal("drawLine","/");
			
			var isDrawLine:Boolean = shareObject.data.drawLine ;
			
			
			
			if(!isDrawLine){
				
				this.startDrag(false);//开始移动
				
			}else{
				
				startDrawClick = true;
				
			}
			
			
			
		}
		
		private function onMouseMove(evnet:MouseEvent):void{
			
			this.refreshLine();
			
		}
		
		private function onMouseUp(event:MouseEvent):void{
			
			this.stopDrag();//停止移动
			
			this.parent.setChildIndex(this,oldIndex);//恢复图标所以的层次
			
		}
		
		
		
		/**
		 
		 * 重绘图标上的连线
		 
		 * */
		
		private function refreshLine():void{
			
			var x:int = this.getCenterX();
			
			var y:int = this.getCenterY();
			
			for(var i:int = 0; i < lineList.length; i++){
				
				var lineFlag:LineLag = lineList[i];
				
				var line:Line = lineFlag.line;
				
				var isHead:Boolean = lineFlag.isHead;
				
				/**
				 
				 * 如果是连线箭头所指的，则重设线条开始位置
				 
				 * 如果不是，则重设连线结束
				 
				 **/
				
				if(isHead){
					
					line.startPoint = new Point(x,y);
					
				}else{
					
					line.endPoint = new Point(x,y);
					
				}
				
				line.drawLine();
				
			}
			
		}
		
		
		
		public function setLine(line:Line,flag:Boolean ):void{
			
			var lineFlag:LineLag = new LineLag(line,flag);
			
			lineList[num] = lineFlag;
			
			num++;
			
		}
		
		
		
		public function getCenterX():int{
			
			return this.x + 20;
			
		}
		
		public function getCenterY():int{
			
			return this.y + 20;
			
		}
		
		
		
		
		
	}
	
}