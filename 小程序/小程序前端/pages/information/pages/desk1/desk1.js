Page({

  /**
   * 页面的初始数据
   */
  data: {
    deskid: '1',
    roomid: '',
    state: ''
  },
  goBack: function () {
    wx.navigateBack()
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.data.deskid = options.deskid
    var that = this
    wx.request({
      //上线接口地址要是https测试可以使用http接口方式
      url: 'http://127.0.0.1/seat/public/index/information/desk',
      data: {
        deskid: this.data.deskid
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
            deskid: getdata[0]['ID'],
            roomid: getdata[0]['RoomID'],
            state: getdata[0]['State']
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