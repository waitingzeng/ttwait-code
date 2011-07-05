package com.ttwait.utils
{
    import com.ttwait.worldedit.items.Line;
    
    import flash.geom.Point;
    import flash.geom.Rectangle;

    public class RectFunc
    {
        public function RectFunc()
        {
            
        }
        
        
        public static function pos_on_rect(point:Point, rect:Rectangle):Boolean{
            if(point.x >= rect.left && point.x <= rect.right && point.y >= rect.top && point.y <= rect.bottom){
                return true;
            }
            return false;
        }
        
        public static function _rect_on_rect(rect1:Rectangle, rect2:Rectangle):int{
            var ct:int = 0;
            if(pos_on_rect(rect1.topLeft, rect2))ct ++;
            if(pos_on_rect(new Point(rect1.right, rect1.top), rect2))ct++;
            if(pos_on_rect(rect1.bottomRight, rect2))ct++;
            if(pos_on_rect(new Point(rect1.left, rect1.bottom), rect2))ct++;
            return ct;
        }
        
        public static function rect_on_rect(rect1:Rectangle, rect2:Rectangle):Boolean{
            return _rect_on_rect(rect1, rect2) > 0;
        }
        
        
        public static function rect_in_rect(rect1:Rectangle, rect2:Rectangle):Boolean{
            return _rect_on_rect(rect1, rect2) == 4;
        }
        
        
        public static function line_intersect(line1:Line, line2:Line):Point{
            
            var crossPoint:Point = new Point();
            var tempLeft:Number;
            var tempRight:Number;
            var q2:Point = line2.startPoint;
            var q1:Point = line2.endPoint;
            var p1:Point = line1.startPoint;
            var p2:Point = line1.endPoint;
            //求x坐标  
            tempLeft = (q2.x - q1.x) * (p1.y - p2.y) - (p2.x - p1.x) * (q1.y - q2.y);  
            tempRight = (p1.y - q1.y) * (p2.x - p1.x) * (q2.x - q1.x) + q1.x * (q2.y - q1.y) * (p2.x - p1.x) - p1.x * (p2.y - p1.y) * (q2.x - q1.x);  
            crossPoint.x = tempRight / tempLeft;  
            //求y坐标    
            tempLeft = (p1.x - p2.x) * (q2.y - q1.y) - (p2.y - p1.y) * (q1.x - q2.x);  
            tempRight = p2.y * (p1.x - p2.x) * (q2.y - q1.y) + (q2.x- p2.x) * (q2.y - q1.y) * (p1.y - p2.y) - q2.y * (q1.x - q2.x) * (p2.y - p1.y);  
            crossPoint.y = tempRight / tempLeft;  
            return crossPoint;  
            
        }
        
        
        public static function segment_intersect(line1:Line, line2:Line):Point{
            var p:Point = line_intersect(line1, line2);
            var rect1:Rectangle = line1.to_rect();
            var rect2:Rectangle = line2.to_rect();
            if(pos_on_rect(p, rect1) && pos_on_rect(p, rect2)){
                return p;
            }
            return null;
            
        }
        
        public static function rect_to_line(rect:Rectangle):Array{
            var obj:Array = new Array();
            var topRight:Point = new Point(rect.right, rect.top);
            var bottomLeft:Point = new Point(rect.left, rect.bottom);
            obj.push(new Line(rect.topLeft, topRight));
            obj.push(new Line(bottomLeft, rect.bottomRight));
            obj.push(new Line(rect.topLeft, bottomLeft));
            obj.push(new Line(topRight, rect.bottomRight));
            return obj;
        }
        
        public static function line_intersect_rect_all(line:Line, rect:Rectangle):Array{
            var lines:Array = rect_to_line(rect);
            var ps:Array = new Array();
            for each(var l:Line in lines){
                var p:Point = line_intersect(line, l);
                if(p){
                    ps.push(p);
                }
            }
            return ps;
        }
        
        public static function segment_intersect_rect_all(line:Line, rect:Rectangle):Array{
            var lines:Array = rect_to_line(rect);
            var ps:Array = new Array();
            for each(var l:Line in lines){
                var p:Point = segment_intersect(line, l);
                if(p){
                    ps.push(p);
                }
            }
            return ps;
        }
        
        public static function segment_intersect_rect(line:Line, rect:Rectangle):Point{
            var ps:Array = segment_intersect_rect_all(line, rect);
            if(ps.length > 1)return null;
            return ps[0];
        
        }
        
        public static function get_short_line(ps1:Array, ps2:Array):Array{
            var mini:int = 999999999;
            var s1:Point;
            var s2:Point;
            for each(var p:Point in ps1){
                
                for each(var p1:Point in ps2){
                    
                    var d:int = Point.distance(p, p1);
                    if(d < mini){
                        mini = d;
                        s1 = p;
                        s2 = p1;
                    }
                }
            }
            var res:Array = new Array();
            res.push(s1);
            res.push(s2);
            return res;
        }
        
    }
}