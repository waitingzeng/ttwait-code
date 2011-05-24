package com
	
{
	
	import flash.geom.Point;
	
	import mx.core.UIComponent;
	
	
	
	public class Line extends UIComponent
		
	{
		
		//起启节点
		
		public var startPoint:Point;
		
		//结束节点、
		
		public var endPoint:Point;
		
		//是否有箭头
		
		public var isArrow:Boolean = true;
		
		//箭头大小
		
		public var arrowSize:uint = 6;
		
		//颜色
		
		public var lineColor:uint = 0x000000;
		
		//提示语
		
		public var tip:String = "线条";
		
		
		
		
		
		public function Line()
			
		{
			
			super();
			
		}
		
		
		
		public function drawLine(){
			
			this.graphics.clear();
			
			this.graphics.lineStyle(2,lineColor);
			
			this.graphics.moveTo(startPoint.x,startPoint.y);
			
			this.graphics.lineTo(endPoint.x,endPoint.y);
			
			this.toolTip = tip;
			
			//画箭头
			
			if(isArrow){
				
				var angle:Number  = this.getAngle();
				
				var centerX:Number = endPoint.x - arrowSize * Math.cos(angle*(Math.PI/180));
				
				var centerY:Number = endPoint.y + arrowSize * Math.sin(angle*(Math.PI/180));
				
				
				
				var leftX:Number = centerX + arrowSize * Math.cos((angle+120)*(Math.PI/180));
				
				var leftY:Number = centerY - arrowSize * Math.sin((angle+120)*(Math.PI/180));
				
				var rightX:Number = centerX + arrowSize * Math.cos((angle+240)*(Math.PI/180));
				
				var rightY:Number = centerY - arrowSize * Math.sin((angle+240)*(Math.PI/180));
				
				
				
				//this.graphics.beginFill(lineColor,1);
				
				this.graphics.lineStyle(2,lineColor,1);
				
				
				
				this.graphics.moveTo(endPoint.x,endPoint.y);
				
				
				
				this.graphics.lineTo(leftX,leftY);
				
				this.graphics.lineTo(centerX,centerY);
				
				
				
				this.graphics.lineTo(rightX,rightY);
				
				this.graphics.lineTo(endPoint.x,endPoint.y);
				
				
				
				//this.graphics.endFill();
				
			}
			
			
			
		}
		
		//得到线的角度
		
		private function getAngle():Number{
			
			var temX:Number = endPoint.x - startPoint.x;
			
			var temY:Number = startPoint.y - endPoint.y;
			
			var angle:Number = Math.atan2(temY,temX)*(180/Math.PI)
			
			return angle;
			
		}
		
		//删除
		
		public function removeLine():void{
			
			this.graphics.clear();
			
		}
		
		
		
	}
	
}