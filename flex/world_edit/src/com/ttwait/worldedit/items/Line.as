package com.ttwait.worldedit.items
{
    import com.ttwait.utils.RectFunc;
    
    import flash.display.BitmapData;
    import flash.events.IEventDispatcher;
    import flash.events.KeyboardEvent;
    import flash.events.MouseEvent;
    import flash.geom.Point;
    import flash.geom.Rectangle;
    
    import mx.core.BitmapAsset;
    import mx.core.DragSource;
    import mx.core.UIComponent;
    import mx.events.PropertyChangeEvent;
    import mx.managers.DragManager;
    
    
    
    public class Line extends UIComponent
        
    {
        
        //起启节点
        
        public var startPoint:Point;
        
        //结束节点、
        
        public var endPoint:Point;
        
        public var startDoor:RaidDoor = null;
        public var endDoor:RaidDoor = null;
        
        public var lineInfo:Object = null;
        
        //是否有箭头
        
        public var isArrow:Boolean = true;
        
        //箭头大小
        
        public var arrowSize:uint = 6;
        
        //颜色
        
        public var lineColor:uint = 0x000000;
        
        public var normalCorlor:uint = 0x000000;
        public var selectColor:uint = 0xFFFFFF;
        //提示语
        
        public var dragPoint:Point;
        
        
        
        
        public function Line(p1:Point, p2:Point)
        {
            
            super();
            this.startPoint = p1;
            this.endPoint = p2;
            this.setTip();
            
        }
        
        public override function toString():String{
            return this.setTip();
        }
        
        public function setTip():String{
            if(!this.startDoor){
                return "startX:" + this.startPoint.x + ',startY:' + this.startPoint.y + ',endX:' + this.endPoint.x + ',endY:' + this.endPoint.y;
            }else{
                return "from:" + this.startDoor.toString() + ", to:" + this.endDoor.toString();
            }
        }
        
        public function get_k():Number{
            return (this.startPoint.x-this.endPoint.x)/(this.startPoint.y-this.endPoint.y);  
        }
        
        public function get_b():Number{
            return this.startPoint.y - this.get_k() * this.startPoint.x; 
        }
        
        public function to_rect():Rectangle{
            var r1:Point = new Point();
            var r2:Point = new Point();
            r1.x = Math.min(this.startPoint.x, this.endPoint.x);
            r1.y = Math.min(this.startPoint.y, this.endPoint.y);
            r2.x = Math.max(this.startPoint.x, this.endPoint.x);
            r2.y = Math.max(this.startPoint.y, this.endPoint.y);
            return new Rectangle(r1.x, r1.y, r2.x - r1.x, r2.y - r1.y);
        }
        
        
        public function drawLine():void{
            
            this.graphics.clear();
            
            this.graphics.lineStyle(3,lineColor);
            
            this.graphics.moveTo(startPoint.x,startPoint.y);
            
            this.graphics.lineTo(endPoint.x,endPoint.y);
            
            this.toolTip = this.setTip();
            
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
        
        public function remove():void{
            if(this.parent){
                this.parent.removeChild(this);
                this.removeLine();
                if(this.startDoor){
                    this.startDoor.door.room.removeLine(this);
                }
                if(this.endDoor){
                    this.endDoor.door.room.removeLine(this);
                }
                this.parentApplication.removeLine(this);
            }
        }
        
        public function refresh(event:PropertyChangeEvent=null):void{
            if(this.startDoor && this.endDoor){
                this.startPoint = this.startDoor.door.toPoint();
                this.endPoint = this.endDoor.door.toPoint();
            }
            this.removeLine();
            this.drawLine();
        }
        
        public function change():void{
            if(this.startDoor && this.endDoor){
                var ps:Array = RectFunc.line_intersect_rect_all(this, this.startDoor.door.room.get_rect());
                var ps1:Array = RectFunc.line_intersect_rect_all(this, this.endDoor.door.room.get_rect());
                var res:Array = RectFunc.get_short_line(ps, ps1);
                this.startDoor.door.setPoint(res[0]);
                this.endDoor.door.setPoint(res[1]);
            }
        }
        
        public function setDoor(startDoor:Door, endDoor:Door):void{
            this.startDoor = new RaidDoor();
            this.startDoor.setDoor(startDoor);
            this.endDoor = new RaidDoor();
            this.endDoor.setDoor(endDoor);
            
            IEventDispatcher(this.startDoor.door).addEventListener(PropertyChangeEvent.PROPERTY_CHANGE, this.refresh);
            IEventDispatcher(this.endDoor.door).addEventListener(PropertyChangeEvent.PROPERTY_CHANGE, this.refresh);
            this.parent.addChild(this.startDoor);
            this.parent.addChild(this.endDoor);
        }
    }
    
}