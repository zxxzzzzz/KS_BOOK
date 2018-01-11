Page({
  data: {
    key: '08:08',  //请输入暂离开始时间
    data: '22:34',  //请输入暂离结束时间
    dialog: {
      title: '',
      content: '',
      hidden: true
    }
  },
  keyChange: function (e) {
    this.data.key = e.detail.value
  },
  dataChange: function (e) {
    this.data.data = e.detail.value
  },
  getOut: function () {
    var that = this
    var key = this.data.key
    var data = this.data.data
    if (key.length === 0) {
      this.setData({
        key: key,
        data: data,
        'dialog.hidden': false,
        'dialog.title': '请输入暂离开始时间',
        'dialog.content': '暂离开始时间不能为空'
      })
    } else if (data.length == 0){
      this.setData({
        key: key,
        data: data,
        'dialog.hidden': false,
        'dialog.title': '请输入暂离结束时间',
        'dialog.content': '暂离结束时间不能为空'
      })
    } else {
      wx.request({
        url: 'http://localhost/seat/public/index/student1/getout',
        data: {
          //这里应该要传入时间和两个id
        time:this.data.key,
        deadline:this.data.data,
        userid:'3', //这个userid和deskid之后再进行修改
        deskid:'2'
        },
        header: {
          'Content-Type': "application/json"
        },
        success: function (res) {
          console.log(res.data['result'])
          console.log(res.data.result)
          console.log(res.data[0])
          console.log(res.data.result)
          console.log(res.result)
          console.log(res.data)
         
          if (res.data.result != "fail") {
            that.setData({
              'dialog.hidden': false,
              'dialog.title': '暂离成功',
              'dialog.content': '你已暂离成功'
            })
          } else {
            that.setData({
              'dialog.hidden': false,
              'dialog.title': '暂离失败',
              'dialog.content': '你已连接成功但是暂离失败！'
            })
          }
        },
        fail: function (res) {
          that.setData({
            'dialog.hidden': false,
            'dialog.title': '连接失败',
            'dialog.content': '暂离失败，请稍后重试'
          })
        }

      })
    }

  // wx.navigateBack() //跳转到导航页面
  },
  confirm: function () {
    this.setData({
      'dialog.hidden': true,
      'dialog.title': '',
      'dialog.content': ''
    })
    wx.navigateBack();
  }
})
