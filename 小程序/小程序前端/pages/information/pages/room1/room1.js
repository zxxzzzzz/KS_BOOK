Page({

  /**
   * 页面的初始数据
   */
  data: {
    roomid: '1',
    Name: '',
    OpenDay: '',
    OrderDay: '',
    FloorID:'',
    OrderEndTime: ''
  },
  goBack: function () {
    wx.navigateBack()
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.data.roomid = options.roomid
    var that = this
    wx.request({
      //上线接口地址要是https测试可以使用http接口方式
      url: 'http://127.0.0.1/seat/public/index/information/room',
      data: {
        roomid: this.data.roomid
      },  
      method: 'GET',
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        var getdata = res.data
        console.log(res)
        if (res != '') {
          that.setData({
            Name: getdata[0]['Name'],
            OpenDay: getdata[0]['OpenDay'],
            OrderDay: getdata[0]['OrderDay'],
            FloorID: getdata[0]['FloorID'],
            OrderEndTime: getdata[0]['LeaveLength']
          })
        }
      },

    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})