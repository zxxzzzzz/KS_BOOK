use ks; -- 使用课设这个数据库
select * from TBUser;
-- 自增的字段没有插入数据，MySQL会自己插入的
-- 插入用户表
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('张三','123456','学生','no','no',0);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('李四','123456','学生','no','yes',-10);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('刘星','123456','教师','no','no',0);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('张奇','123456','教师','no','no',0);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('王二','123456','管理员','no','no',0);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('郑文','123456','学生','no','no',0);
insert into TBUser (Name,Password,Role,Online,BlackList,Score) values ('萌萌','123456','学生','no','no',0);

-- alter table TBFloor drop FloorNum;
-- 插入楼层模块
insert into TBFloor (Name,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength)
values ('楼层一','早上8点到晚上10点',3,'08:00:00','22:00:00',30);  
insert into TBFloor (Name,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength)
values ('楼层二','早上7点到晚上9点',3,'07:00:00','21:00:00',50);  
insert into TBFloor (Name,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength)
values ('楼层三','早上10点到晚上7点',3,'10:00:00','19:00:00',30);  

-- 插入教室模块(阅览室)
select * from TBRoom;

insert into TBRoom (Name,FloorID,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength,Flag)
values ('阅览室1',1,'早上8点到晚上9点',3,'08:00:00','21:00:00',30,'no'); 
insert into TBRoom (Name,FloorID,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength,Flag)
values ('阅览室2',1,'早上10点到晚上7点',2,'10:00:00','19:00:00',50,'yes');
insert into TBRoom (Name,FloorID,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength,Flag)
values ('阅览室3',2,'早上10点到晚上7点',5,'10:00:00','19:00:00',90,'no');
insert into TBRoom (Name,FloorID,OpenDay,OrderDay,OrderTime,OrderEndTime,LeaveLength,Flag)
values ('阅览室4',2,'早上9点到晚上10点',5,'09:00:00','22:00:00',90,'no');

-- 插入座位模块
-- select * from TBDesk;
-- UserID 默认值为0，一开始座位没有预定的时候，可以不插入UserID的值
insert into TBDesk (RoomID,State,UserID)  values  (1,'empty',0);
insert into TBDesk (RoomID,State,UserID)  values  (1,'ordering',6); -- 对应上面插入的学生数据：郑文
insert into TBDesk (RoomID,State,UserID)  values  (1,'leaving',7); --  对应上面插入的学生数据：萌萌
insert into TBDesk (RoomID,State)  values  (1,'empty');
insert into TBDesk (RoomID,State)  values  (1,'empty');
insert into TBDesk (RoomID,State)  values  (1,'empty');
insert into TBDesk (RoomID,State)  values  (1,'empty');
insert into TBDesk (RoomID,State)  values  (2,'empty');
insert into TBDesk (RoomID,State)  values  (2,'empty');
insert into TBDesk (RoomID,State)  values  (2,'empty');
insert into TBDesk (RoomID,State)  values  (2,'empty');
insert into TBDesk (RoomID,State)  values  (3,'empty');


-- 违规记录表 使用学生李四做测试，因为他在黑名单里面啦！加起来刚好扣掉10分
-- select * from TBAgainstHistory
insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score)
values (2,'2017:12:25','在座位上吃东西',2,1);
insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score)
values (2,'2017:11:18 08:30:20','在阅览室喧哗',2,2);
insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score)
values (2,'2017:12:19','离开座位未按时回归',2,1);
insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score)
values (2,'2017:10:18','在学习时晒臭脚',2,5);
insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score)
values (2,'2017:12:24','在座位上吃东西',2,1);


-- select * from TBOrderHistory;
-- 预约历史记录表  以李四为例
insert into TBOrderHistory (UserID,Time,Deadline,DeskID) values (2,'2017:12:25 08:00:00','2017:12:25 16:00:00',2);
insert into TBOrderHistory (UserID,Time,Deadline,DeskID) values (2,'2017:11:18 08:00:20','2017:11:18 17:30:20',2);
insert into TBOrderHistory (UserID,Time,Deadline,DeskID) values (2,'2017:12:19 09:00:00','2017:12:19 21:00:00',2);
insert into TBOrderHistory (UserID,Time,Deadline,DeskID) values (2,'2017:10:18 10:00:00','2017:10:18 16:00:00',2);
insert into TBOrderHistory (UserID,Time,Deadline,DeskID) values (2,'2017:09:24 00:00:00','2017:09:24 00:00:00',2);


-- 预约记录  TBOrder 座位模块只插入了两条正在使用数据，所以这里就只有两条数据啦
-- 他们都没有离开，所以这个表中deadline也不插入数据啦  
insert into TBOrder(UserID,Time,DeskID) values (6,'2018:01:11 09:00:00',2);  -- 对应学生 ：郑文
insert into TBOrder(UserID,Time,DeskID) values (7,'2018:01:11 08:00:00',3);  -- 对应学生 ：萌萌