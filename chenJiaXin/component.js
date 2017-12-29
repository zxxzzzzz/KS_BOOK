/**
 * <login-box url="www.baidu.com" title="登录"></login-box>
 * login-box
 * like
 * ------------------title-----------------
 * |            ===========               |
 * |            ===========               |
 * |                            button    |
 * |______________________________________|
 *  param:
 *       url:str request url
 *       title:str 
 */
Vue.component('login-box', {
    props: ['url','title'],
    template:
    `<div>
        <div class="am-u-sm-12 am-panel am-panel-default">
            <div class="am-panel-hd">{{title}}</div>
            <br>
            <br>
            <div class="am-form">
                <div>用户名</div>
                <input  v-model="name" type="text" placeholder="edit me">
                <div>密码</div>
                <input v-model="password" type="text" type="text" placeholder="edit me">
                <br>
                <button v-on:click="login" class="am-btn am-btn-secondary am-fr">登录</button>
            </div>
            <br>
            <br>
        </div>
    </div>`,
    data:function(){
        return {
            name:'',
            password:'',
        }
    },
    methods:{
        login:function(){
            doAjax(this.url, 'post', {data:{Name:this.name, Password:this.password}},
                function (data) {
                    console.log(data)
                }
            )
        }
    },
    
    
})
