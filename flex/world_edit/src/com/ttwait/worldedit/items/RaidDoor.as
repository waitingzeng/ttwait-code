package com.ttwait.worldedit.items
{
    import flash.events.IEventDispatcher;
    import flash.geom.Point;
    import flash.geom.Rectangle;
    
    import mx.containers.Canvas;
    import mx.controls.Image;
    import mx.events.PropertyChangeEvent;
    
    import spark.primitives.Rect;
    
    [Bindable]
    public class RaidDoor extends Canvas
    {
        
        public var door:Door = null;
        public var door_id:int = 0;
        
        [Embed(source="images/icons/door.png")]
        private var doorPic:Class;//关闭按钮图片
        
        public var doorImg:Image = new Image();
        
        public function RaidDoor()
        {
            super();
            this.doorImg.data = new doorPic();
            this.doorImg.width = 10;
            this.doorImg.height = 10;
            this.addChild(this.doorImg);
        }
        
        public function setRoom(room:Room):void{
            door = new Door(room, null);
            IEventDispatcher(door).addEventListener(PropertyChangeEvent.PROPERTY_CHANGE, this.update);
            
        }
        
        public function setDoor(door:Door):void{
            this.door = door;
            IEventDispatcher(door).addEventListener(PropertyChangeEvent.PROPERTY_CHANGE, this.update);
            this.update();
        }
        
        public function update(event:PropertyChangeEvent = null):void{
            var p:Point = this.door.toPoint();
            this.x = p.x - 5;
            this.y = p.y - 5;
        }
        public function to_rect():Rectangle{
            return new Rectangle(this.x, this.y, this.width, this.height);
        }
        
    }
}