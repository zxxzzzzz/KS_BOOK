var util = require('../../../../utils/util.js');


Page({
  data: {
    result: '',
    dialog: {
      title: '',
      content: '',
      hidden: true
    }
  },
  scanCode: function () { //这个在开发工具里面要输入appid才能够使用
    var that = this
    wx.scanCode({   //这个在开发工具里面要输入appid才能够使用
      success: function (res) {
        that.setData({
          result: res.result
        })
        console.log(res.result)
        var a = res.result.split('?')
        console.log(a[0])
        console.log(a[1])
        var b = a[1].split('=')
        console.log(b[1]) //说明，二维码默认包含了学校图书馆座位的deskid(座位id)和跳转的链接地址

        //二维码扫描成功后登录，自动跳转到别的界面
        //扫描二维码之后得到deskid，然后跳转界面提醒用户输入用户名、密码
        //还是微信小程序本身就存储了用户名密码------采用这种方式
        wx.request({
          //上线接口地址要是https测试可以使用http接口方式
          url: a[0], //改成截取到的字符串'http://localhost/seat/public/index/student1/getin'
          data: {
            Name: "张三", //这里之后采用从微信小程序获取用户信息的方式
            Password: '123456',
            ID: '3',//用户id
            DeskID: b[1] //改成截取到的字符串
          },
          method: 'GET',
          header: {
            'content-type': 'application/json'
          },
          success: function (res) {
            console.log(res.data.result)
            if (res.data.result == "success") {
              that.setData({
                'dialog.hidden': false,
                'dialog.title': '连接成功',
                'dialog.content': '你已成功登录'
              })
            } else {
              that.setData({
                'dialog.hidden': false,
                'dialog.title': '登录失败',
                'dialog.content': '你已连接成功但是登录失败！'
              })
            }
          },
          fail: function (res) {
            that.setData({
              'dialog.hidden': false,
              'dialog.title': '连接失败',
              'dialog.content': '登录失败，请稍后重试'
            })
          }
        })


      },
      fail: function (res) {
        that.setData({
          'dialog.hidden': false,
          'dialog.title': '登录失败',
          'dialog.content': '二维码扫描失败'
        })
      }
    })

  },
  confirm: function () {//加入一个弹出框提醒用户签到成功
    this.setData({
      'dialog.hidden': true,
      'dialog.title': '',
      'dialog.content': ''
    })
    wx.navigateBack(); //返回导航页面
  }

  
})
