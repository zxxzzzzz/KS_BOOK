Page({
  data: {
    list: [
      {
        id: 'getin',
        name: '签到',
        open: false,
        pages: ['getin']
      }, {
        id: 'getout',
        name: '暂离',
        open: false,
        pages: ['getout']
      }, {
        id: 'over',
        name: '注销',
        open: false,
        pages: ['over']
      }
    ]
  },
  kindToggle: function (e) {
    var id = e.currentTarget.id, list = this.data.list;
    for (var i = 0, len = list.length; i < len; ++i) {
      if (list[i].id == id) {
        list[i].open = !list[i].open
      } else {
        list[i].open = false
      }
    }
    this.setData({
      list: list
    });
  }
})

