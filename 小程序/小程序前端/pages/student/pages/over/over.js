// 在需要使用的js文件中，导入js  
var util = require('../../../../utils/util.js');  


Page({
  data: {
    key: '',
    deadline:'',
    dialog: {
      title: '',
      content: '',
      hidden: true
    }
  },
  goBack:function(){
    wx.navigateBack()
  },
  onLoad: function () {
    var time = util.formatTime(new Date());
    var getkey = '';
    var mythis = this;
    wx.request({
      //上线接口地址要是https测试可以使用http接口方式
      url: 'http://localhost/seat/public/index/student1/sendover',
      data: {
        id:'7' //在这里从微信小程序获取用户的id
      },
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        
        getkey = res.data;
        console.log(getkey);
        if(getkey != ''){
          mythis.setData({
            key: getkey[0]['Time'],
          });
        }
      },

    })

    this.setData({
      deadline: time,
      key:getkey
    });
  },
  keyChange: function (e) {
    this.data.key = e.detail.value
  },
  dataChange: function (e) {
    this.data.deadline = e.detail.deadline
  },
  setStorage: function () {
    var key = this.data.key
    var deadline = this.data.deadline
    var that = this
    if (key.length === 0) {
      this.setData({
        key: key,
        deadline: datdeadlinea,
        'dialog.hidden': false,
        'dialog.title': '座位注销失败',
        'dialog.content': '占座开始时间不能为空'
      })
    } else if(deadline.length == 0) {
      that.setData({
        key: key,
        deadline: datdeadlinea,
        'dialog.hidden': false,
        'dialog.title': '注销座位失败',
        'dialog.content': '占座结束时间不能为空'
      })
    }
    else {
      wx.request({
        url: 'http://localhost/seat/public/index/student1/getover',
        data: this.data, //这一句就把所有的数据传入后台了，需要后台进行处理
        header:{
          'Content-Type':"application/json"
        },
        success:function(res){
          console.log(res.data)
          wx.setStorageSync(key, deadline)
          that.setData({
            key: key,
            deadline: deadline,
            'dialog.hidden': false,
            'dialog.title': '注销座位成功'
          })
        },
        complete:function(){

        }
      })
    }
  },
  clearStorage: function () {
    wx.clearStorageSync()
    this.setData({
      key: '',
      deadline: '',
      'dialog.hidden': false,
      'dialog.title': '清除数据成功',
      'dialog.content': ''
    })
  },
  confirm: function () {
    this.setData({
      'dialog.hidden': true,
      'dialog.title': '',
      'dialog.content': ''
    })
    wx.navigateBack(); //返回导航页面
  }
})
