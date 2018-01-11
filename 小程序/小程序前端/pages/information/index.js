Page({
  data: {
    list: [
      {
        id: 'floor',
        name: '楼层',
        open: false,
        pages: ['floor']
      }, {
        id: 'room',
        name: '教室',
        open: false,
        pages: ['room']
      }, {
        id: 'desk',
        name: '课桌',
        open: false,
        pages: ['desk']
      }/*, {
        id: 'rule',
        name: '预约规则',
        open: false,
        pages: ['rule']
      }*/
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

