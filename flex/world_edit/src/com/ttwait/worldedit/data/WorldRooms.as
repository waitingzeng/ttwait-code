package com.ttwait.worldedit.data
{
    import com.ttwait.network.Network;
    import com.ttwait.worldedit.items.Line;
    
    import flash.net.URLRequest;
    import flash.net.URLVariables;
    import flash.net.navigateToURL;
    
    import mx.controls.Alert;
    
    public class WorldRooms
    {
        import com.adobe.serialization.json.JSON;
        private var map_list:Object = new Object();
        private var room_dict:Object = new Object();
        private var room_ids:Array = new Array();
        private var removeLines:Array = new Array();
        private var door_dict:Object = new Object();
        
        private var _callback:Function;
        public function WorldRooms()
        {
            
        }
        
        public function load(callback:Function):void{
            this._callback = callback;
            Network.getJSON('/map/roomlist/?' + Math.random(), null, processData);
        }
        
        private function processData(data:Object):void{
            trace(data);
            map_list = data;
            for each(var mapitem:Object in data){
                for each(var roomitem:Object in mapitem.rooms){
                    room_dict[roomitem.room_id] = roomitem;
                    if(roomitem.door){
                        door_dict[roomitem.map_id] = roomitem.door;
                    }
                }
            }
            this._callback();
        }
        
        public function setHadRooms(room_ids:Array):void{
            this.room_ids = room_ids;
        }
        
        public function getRoomInfo(room_id:int):Object{
            return room_dict[room_id];
        }
        
        public function _roomIdUsed(room_id:int):Boolean{
            for each(var item:Object in this.room_ids){
                if(room_id.toString() == item.toString())
                    return true;
            }
            return false;
        }
        
        public function getTreeXml():XMLList{
            var xmldata:XML = <maps/>;
            for each(var mapitem:Object in map_list){
                var mapNode:XML = <map/>;
                mapNode.@id = mapitem.map_id;
                mapNode.@name = mapitem.name;
                for each(var roomitem:Object in mapitem.rooms){
                    var roomNode:XML = <room/>;
                    if(roomitem.x >=0 || roomitem.y >= 0)
                        continue;
                    roomNode.@id = roomitem.room_id;
                    roomNode.@img = roomitem.resource;
                    roomNode.@name = roomitem.name;
                    mapNode.appendChild(roomNode);
                }
                if(mapNode.room.length() > 0){
                    trace(mapNode);
                    xmldata.appendChild(mapNode);         
                }
            }
            //trace(xmldata.map);
            return xmldata.map;
        }
        
        public function getWorldRoom():Array{
            var rooms:Array = new Array();
            for each(var mapitem:Object in map_list){
                for each(var roomitem:Object in mapitem.rooms){
                    
                    if(roomitem.x == -1 || roomitem.y == -1)
                        continue;
                    rooms.push(roomitem);
                }
            }
            return rooms;
        }
        
        
        
        public function save():void{
            var infos:Array = new Array();
            var lines:Array;
            for each(var mapitem:Object in map_list){
                for each(var roomitem:Object in mapitem.rooms){
                    var info:Object = new Object();
                    info.room_id = roomitem.room_id;
                    
                    
                    info.x = roomitem.x;
                    info.y = roomitem.y;
                    //if(info.x == -1 || info.y == -1)
                    //    continue;
                    
                    info.lines = roomitem.lines;
                    info.door = roomitem.door;
                    infos.push(info);
                }
                
            }
            var params:URLVariables = new URLVariables("data=" + JSON.encode(infos));
            trace(params.toString());
            Network.getJSON('/map/saverooms/?' + Math.random(), params, function(data:Object):void{
                if(data.code == 0){
                    Alert.show("保存成功");
                    var urlRequest:URLRequest = new URLRequest(Configuration.getUrl("/map/world_edit/"));
                    navigateToURL(urlRequest, '_top');
                    
                }
            });
        }
        
        public function removeLine(line:Line):void{
            if(!line.lineInfo)return;
            
            line.lineInfo.del = 1;
            
        }
        
        public function had_door(map_id:int):Boolean{
            return map_id in door_dict;
        }
        
        public function del_door(map_id:int):void{
            if(map_id in door_dict){
                door_dict[map_id].del = 1;
                delete door_dict[map_id];
            }
            
        }
    }
}