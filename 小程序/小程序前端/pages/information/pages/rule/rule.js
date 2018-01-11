Page({

  /**
   * 页面的初始数据
   */
  data: {
    array:['按阅览室规则查询','按楼层规则查询'],
    index:0
  },
  bindPickerChange:function(e){
    this.setData({
      index:e.detail.value
    })
  },
  sureSeach:function(e){
    //确认选择之后按照查询条件查找不同的数据
    console.log(this.data.array[this.data.index] + "rule11111")
    if (this.data.array[this.data.index] == '按阅览室规则查询') {//按阅览室规则查询
      //跳转的时候传入不同的参数
      wx.navigateTo({
        url: '../rule1/rule1?judge=1'
      })
    } else { //按楼层规则查询
      wx.navigateTo({
        url: '../rule1/rule1?juge=2',
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    
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