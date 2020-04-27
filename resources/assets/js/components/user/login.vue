<template>
  <div>
    <div class="loginWraper">
      <div id="loginform" class="loginBox">
        <div class="form form-horizontal">
          <div class="row cl">
            <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
            <div class="formControls col-xs-8">
              <input v-model.trim="username" type="text" placeholder="账户" class="input-text size-L" @blur="uname">
            </div>
          </div>
          <div class="row cl">
            <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
            <div class="formControls col-xs-8">
              <input v-model.trim="password" type="password" placeholder="密码" class="input-text size-L" @blur="pass">
            </div>
          </div>
          <div class="row cl">
            <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe63f;</i></label>
            <div class="formControls col-xs-8">
              <input class="input-text size-L" type="text" placeholder="验证码" v-model.trim="captcha" @blur="verity" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
              <img src="" class="captcha"> <a id="kanbuq" href="javascript:;" @click="switchs">看不清，换一张</a> </div>
          </div>
          <div class="row cl">
            <div class="formControls col-xs-8 col-xs-offset-3">
              <label for="online">
                <input type="checkbox" name="online" id="online" value="">
                使我保持登录状态</label>
            </div>
          </div>
          <div class="row cl">
            <div class="formControls col-xs-8 col-xs-offset-3">
              <el-button type="success" @click="submitLogin">登陆</el-button>
              <el-button @click="cancel">取消</el-button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">Copyright 测试公司 by ws</div>
  </div>
  
</template>
<script scoped>
  export default({
    data(){
      return {
        username: '',
        password: '',
        captcha: ''
      }
    },
    components: {

    },
    computed: {},
    methods: {
      uname(){
        const that = this;
        if (that.$data.username == "" || that.$data.username == null || that.$data.username == undefined) {
          that.$message({
            showClose: true,
            message: '管理员名不能为空',
            type: 'error'
          });
          return false;
        }
      },
      pass(){
        const that = this;
        if (that.$data.password == "" || that.$data.password == null || that.$data.password == undefined) {
          that.$message({
            showClose: true,
            message: '密码不能为空',
            type: 'error'
          });
          return false;
        }
      },
      verity() {
        const that = this;
        if (that.$data.captcha == "" || that.$data.captcha == null || that.$data.captcha == undefined) {
          that.$message({
            showClose: true,
            message: '验证码不能为空',
            type: 'error'
          });
          return false;
        }
      },
      cancel(){
        const that = this;
        that.$data.captcha = null;
        that.$data.username = null;
        that.$data.password = null;
      },
      submitLogin() {
        const that = this;
        let uname = that.$data.username;
        let pwd = that.$data.password;
        let verity = that.$data.captcha;
        if (uname == "" || uname == null || uname == undefined) {
          that.$message({
            showClose: true,
            message: '管理员名不能为空',
            type: 'error',
            onClose: function () {
              that.switchs()
            }
          });
          return false;
        }
        if (pwd == "" || pwd == null || pwd == undefined) {
          that.$message({
            showClose: true,
            message: '密码不能为空',
            type: 'error',
            onClose: function () {
              that.switchs()
            }
          });
          return false;
        }
        if (verity == "" || verity == null || verity == undefined) {
          that.$message({
            showClose: true,
            message: '验证码不能为空',
            type: 'error',
            onClose: function () {
              that.switchs()
            }
          });
          return false;
        }
        axios.post('/index', {
          params: {
            username: uname,
            password: pwd,
            captcha: verity
          }
        }).then(function (response) {
          console.log(response.data.code);
          if (response.data.code == 400 && response.status == 200) {
            that.$message({
              showClose: true,
              message: response.data.message,
              type: 'error',
              onClose: function () {
                that.switchs()
              }
            });
          } else if (response.data.code == 200 && response.status == 200) {
            that.$message({
              showClose: true,
              message: response.data.message,
              type: 'success',
              onClose: function () {
                
              }
            });
          }
          return false;
        }).catch(function (error) {
          console.log(error);
        });
      },
      switchs() {
        const that = this;
        $(".captcha").attr('src', '/verity?t='+Math.random());
      }
    },
    mounted() {
      $(".captcha").attr('src', '/verity');
    },
  })
</script>