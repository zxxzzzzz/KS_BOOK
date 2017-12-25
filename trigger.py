import pymysql
import time
import datetime
def doSelect(sqlStr):
    db = pymysql.connect('localhost','root','','KS',
                         charset='utf8', 
                         cursorclass=pymysql.cursors.DictCursor)
    cursor = db.cursor()
    cursor.execute(sqlStr)
    data = cursor.fetchall()
    db.close()
    return data

def doInsert(sqlStr):
    db = pymysql.connect('localhost','root','','KS',
                         charset='utf8')
    cursor = db.cursor()
    count = cursor.execute(sqlStr)
    db.commit()
    db.close()
    return count


def sqlFormat(sqlStr,valuesList):
    count = 0
    for i in valuesList:
        sqlStr = sqlStr.replace('value' + str(count), str(i),1)
        count += 1
    return sqlStr

##分数低于0的人加入黑名单
def watchBlacklist():
    sql = 'update TBUser set BlackList = "yes" where Score < 0'
    return doInsert(sql)

# 获取可暂离时间长度
def getDeskleaveLength(deskid):
    sql = 'select * from TBDesk where ID = value0'
    sql = sqlFormat(sql,[deskid])
    roomid = doSelect(sql)[0]['RoomID']
    sql = 'select * from TBRoom where ID = value0'
    sql = sqlFormat(sql,[roomid])
    room = doSelect(sql)[0]
    if room['Flag'] == 'yes':
        return room['LeaveLength']
    else:
        sql = 'select * from TBFloor where ID = value0'
        sql = sqlFormat(sql,[room['FloorID']])
        floor = doSelect(sql)[0]
        return floor['LeaveLength']

#一天结束后进行的操作
def dayEnd():
    # score不大于100的人分数加一
    sql = 'update TBUser set Score = Score + 1 where Score < 100'
    doInsert(sql)
    # 所有座位置emplying状态
    sql = 'update TBDesk set State = "emptying"'
    doInsert(sql)
    print('座位清空，分数加一')

#把 预约/签离 超时的人 放againstHistory表里,移除无效预约,加入历史表
def setLeavingTimeoutToAgainstHitory():
    sql = 'select * from TBOrder'
    orders = doSelect(sql)
    now = datetime.datetime.now()
    for order in orders:
        deadline = order['Deadline']
        #转化为分钟
        deadlineTotalMinutes = int(deadline.strftime('%j'))*24*60 + \
                       int(deadline.strftime('%H'))*60 + \
                       int(deadline.strftime('%M'))
        nowTotalMinutes = int(now.strftime('%j'))*24*60 + \
                       int(now.strftime('%H'))*60 + \
                       int(now.strftime('%M'))
        if deadlineTotalMinutes < nowTotalMinutes: #小于表示，超时（无效预约）
            #删除无效预约从tborder
            sql = 'delete from TBOrder where ID = value0' 
            sql = sqlFormat(sql,[order['ID']])
            doInsert(sql)
            #插入无效预约，去tborderhistory
            sql = 'insert into tbOrderHistory (UserID,Time,Deadline,DeskID) \
                                        values (value0,"value1","value2",value3)' 
            sql = sqlFormat(sql,
                            [order['UserID'],order['Time'],order['Deadline'],order['DeskID']])
            doInsert(sql)
            #插入违约记录，去TBAgainstHistory
            sql = 'insert into TBAgainstHistory (UserID,Time,Detail,DeskID,Score) \
                                        values (value0,"value1","value2",value3,value4)'
            sql = sqlFormat(sql, [order['UserID'], order['Time'],
                                  '预约超时/签到超时', order['DeskID'], 15])
            doInsert(sql)
            #扣相应分数
            sql = 'update TBUser set Score = Score - value0 where ID = value1'
            sql = sqlFormat(sql, [15, order['UserID']])
            doInsert(sql)
            print(now.strftime('%Y-%m-%d %H:%M:%S'),'用户:' + str(order['UserID']) + '超时违规,扣分15')
        

now = datetime.datetime.now()
dayEndFlag = 'yes'
while(True):
    if now.strftime('%H:%M') == '23:59':  #一天结束
        dayEndFlag = 'yes'
    if now.strftime('%H:%M') == '00:00' and dayEndFlag == 'yes':
        #执行一天结束后的打扫程序，dayEnd()
        dayEnd()
        dayEndFlag = 'no'
    watchBlacklist()
    setLeavingTimeoutToAgainstHitory()
    time.sleep(1)
    #print()
    
