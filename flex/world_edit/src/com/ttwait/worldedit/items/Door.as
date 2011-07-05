package com.ttwait.worldedit.items
{
    import com.ttwait.worldedit.items.Room;
    
    import flash.events.KeyboardEvent;
    import flash.geom.Point;

    [Bindable]
    public class Door
    {
        public static var dirs:Object = {0 : '北方', 1 : '东方', 2 : '南方', 3 : '西方'}
        public var room:Room;
        public var dir:int;
        public var pos:int;
        public var isvalid:Boolean = false;
        
        public function Door(room:Room, point:Point)
        {
            this.room = room;
            this.setPoint(point);
        }
        
        public static function getNDir(dir:int):int{
            return (dir + 2) % 4
        }
        
        public function setDirPos(dir:int, pos:int):void{
            var p:Point = new Point();
            if(dir == 0 || dir == 2){
                if(pos > this.room.width)pos = this.room.width;
                if(pos < 0)pos = 0;
                
            }else if(dir == 1 || dir == 3){
                if(pos > this.room.height)pos = this.room.height;
                if(pos < 0)pos = 0;
                
            }
            this.dir = dir;
            this.pos = pos;
            this.isvalid = true;
        }
        
        public function getLocalPoint():Point{
            var p:Point = new Point();
            if(this.dir == 0){
                p.x = pos;
                p.y = 0;
            }else if(dir == 1){
                p.x = this.room.width;
                p.y = pos;
                
            }else if(dir == 2){
                p.x = pos;
                
                p.y = this.room.height;
            }else if(dir == 3){
                p.x = 0;
                p.y = pos;
            }
            return p;
        }
        
        public function setPoint(point:Point, xdelta:int=2, ydelta:int=10):void{
            if(point != null){
                point = new Point(point.x - this.room.x, point.y - this.room.y);
                this.format(point, xdelta, ydelta);
            }
        }
        
        public function format(point:Point, xdelta:int= 2, ydelta:int=2):void{
            if(point.x < xdelta && point.y < ydelta)
                return;
            if(point.x > (this.room.width - xdelta) && point.y > (this.room.height - ydelta))
                return;
            this.isvalid = true;
            var dir:int = -1;
            var pos:int = -1;
            if(point.x < xdelta){
                dir = 3;
                pos = int(point.y);
                
            }
            else if(point.x > (this.room.width -xdelta)){
                dir = 1;
                pos = int(point.y);
                
            }
            else if(point.y < ydelta){
                dir = 0;
                pos = int(point.x);
            }
            else if(point.y > (this.room.height - ydelta)){
                dir = 2;
                pos = int(point.x);
            }else{
                this.isvalid = false;
            }
            if(this.isvalid){
                this.setDirPos(dir, pos);
            }
        }
        
        public function toPoint():Point{
            var p:Point = this.getLocalPoint();
            return new Point(p.x + this.room.x, p.y + this.room.y);   
        }
        
        public function getDir():String{
            return dirs[this.dir];
        }
        
        public function toString():String{
            return this.room.info.name + "_" + Door.dirs[this.dir] + '_' + this.pos.toString();
        }
        
        //a,s,w,d移动编辑区域
        public function move(evet:KeyboardEvent):void{
           
            switch (evet.keyCode)
            {
                case 65:	//a
                    if(this.pos > 0 && (this.dir == 0 || this.dir == 2)){
                        this.pos --;
                    }
                    break;
                case 87:	//w
                    if(this.pos > 0 && (this.dir == 1 || this.dir == 3)){
                        this.pos --;
                    }
                    break;
                case 68:	//d
                    if(this.pos < this.room.width && (this.dir == 0 || this.dir == 2)){
                        this.pos ++;
                    }
                    break;
                case 83:	//s
                    if(this.pos < this.room.height && (this.dir == 1 || this.dir == 3)){
                        this.pos ++;
                    }
                    break;
                
            }
            
            
        }
        
    }
}