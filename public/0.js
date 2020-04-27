webpackJsonp([0],{

/***/ 205:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(79)
/* script */
var __vue_script__ = __webpack_require__(208)
/* template */
var __vue_template__ = __webpack_require__(209)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/user/login.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-400f42fc", Component.options)
  } else {
    hotAPI.reload("data-v-400f42fc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 208:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      username: '',
      password: '',
      captcha: ''
    };
  },

  components: {},
  computed: {},
  methods: {
    uname: function uname() {
      var that = this;
      if (that.$data.username == "" || that.$data.username == null || that.$data.username == undefined) {
        that.$message({
          showClose: true,
          message: '管理员名不能为空',
          type: 'error'
        });
        return false;
      }
    },
    pass: function pass() {
      var that = this;
      if (that.$data.password == "" || that.$data.password == null || that.$data.password == undefined) {
        that.$message({
          showClose: true,
          message: '密码不能为空',
          type: 'error'
        });
        return false;
      }
    },
    verity: function verity() {
      var that = this;
      if (that.$data.captcha == "" || that.$data.captcha == null || that.$data.captcha == undefined) {
        that.$message({
          showClose: true,
          message: '验证码不能为空',
          type: 'error'
        });
        return false;
      }
    },
    cancel: function cancel() {
      var that = this;
      that.$data.captcha = null;
      that.$data.username = null;
      that.$data.password = null;
    },
    submitLogin: function submitLogin() {
      var that = this;
      var uname = that.$data.username;
      var pwd = that.$data.password;
      var verity = that.$data.captcha;
      if (uname == "" || uname == null || uname == undefined) {
        that.$message({
          showClose: true,
          message: '管理员名不能为空',
          type: 'error',
          onClose: function onClose() {
            that.switchs();
          }
        });
        return false;
      }
      if (pwd == "" || pwd == null || pwd == undefined) {
        that.$message({
          showClose: true,
          message: '密码不能为空',
          type: 'error',
          onClose: function onClose() {
            that.switchs();
          }
        });
        return false;
      }
      if (verity == "" || verity == null || verity == undefined) {
        that.$message({
          showClose: true,
          message: '验证码不能为空',
          type: 'error',
          onClose: function onClose() {
            that.switchs();
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
            onClose: function onClose() {
              that.switchs();
            }
          });
        } else if (response.data.code == 200 && response.status == 200) {
          that.$message({
            showClose: true,
            message: response.data.message,
            type: 'success',
            onClose: function onClose() {}
          });
        }
        return false;
      }).catch(function (error) {
        console.log(error);
      });
    },
    switchs: function switchs() {
      var that = this;
      $(".captcha").attr('src', 'index.php/verity?t=' + Math.random());
    }
  },
  mounted: function mounted() {
    $(".captcha").attr('src', 'index.php/verity');
  }
});

/***/ }),

/***/ 209:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "loginWraper" }, [
      _c("div", { staticClass: "loginBox", attrs: { id: "loginform" } }, [
        _c("div", { staticClass: "form form-horizontal" }, [
          _c("div", { staticClass: "row cl" }, [
            _vm._m(0),
            _vm._v(" "),
            _c("div", { staticClass: "formControls col-xs-8" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.trim",
                    value: _vm.username,
                    expression: "username",
                    modifiers: { trim: true }
                  }
                ],
                staticClass: "input-text size-L",
                attrs: { type: "text", placeholder: "账户" },
                domProps: { value: _vm.username },
                on: {
                  blur: [
                    _vm.uname,
                    function($event) {
                      return _vm.$forceUpdate()
                    }
                  ],
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.username = $event.target.value.trim()
                  }
                }
              })
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row cl" }, [
            _vm._m(1),
            _vm._v(" "),
            _c("div", { staticClass: "formControls col-xs-8" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.trim",
                    value: _vm.password,
                    expression: "password",
                    modifiers: { trim: true }
                  }
                ],
                staticClass: "input-text size-L",
                attrs: { type: "password", placeholder: "密码" },
                domProps: { value: _vm.password },
                on: {
                  blur: [
                    _vm.pass,
                    function($event) {
                      return _vm.$forceUpdate()
                    }
                  ],
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.password = $event.target.value.trim()
                  }
                }
              })
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row cl" }, [
            _vm._m(2),
            _vm._v(" "),
            _c("div", { staticClass: "formControls col-xs-8" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.trim",
                    value: _vm.captcha,
                    expression: "captcha",
                    modifiers: { trim: true }
                  }
                ],
                staticClass: "input-text size-L",
                staticStyle: { width: "150px" },
                attrs: {
                  type: "text",
                  placeholder: "验证码",
                  onblur: "if(this.value==''){this.value='验证码:'}",
                  onclick: "if(this.value=='验证码:'){this.value='';}",
                  value: "验证码:"
                },
                domProps: { value: _vm.captcha },
                on: {
                  blur: [
                    _vm.verity,
                    function($event) {
                      return _vm.$forceUpdate()
                    }
                  ],
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.captcha = $event.target.value.trim()
                  }
                }
              }),
              _vm._v(" "),
              _c("img", { staticClass: "captcha", attrs: { src: "" } }),
              _vm._v(" "),
              _c(
                "a",
                {
                  attrs: { id: "kanbuq", href: "javascript:;" },
                  on: { click: _vm.switchs }
                },
                [_vm._v("看不清，换一张")]
              )
            ])
          ]),
          _vm._v(" "),
          _vm._m(3),
          _vm._v(" "),
          _c("div", { staticClass: "row cl" }, [
            _c(
              "div",
              { staticClass: "formControls col-xs-8 col-xs-offset-3" },
              [
                _c(
                  "el-button",
                  {
                    attrs: { type: "success" },
                    on: { click: _vm.submitLogin }
                  },
                  [_vm._v("登陆")]
                ),
                _vm._v(" "),
                _c("el-button", { on: { click: _vm.cancel } }, [_vm._v("取消")])
              ],
              1
            )
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "footer" }, [_vm._v("Copyright 测试公司 by ws")])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "form-label col-xs-3" }, [
      _c("i", { staticClass: "Hui-iconfont" }, [_vm._v("")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "form-label col-xs-3" }, [
      _c("i", { staticClass: "Hui-iconfont" }, [_vm._v("")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "form-label col-xs-3" }, [
      _c("i", { staticClass: "Hui-iconfont" }, [_vm._v("")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row cl" }, [
      _c("div", { staticClass: "formControls col-xs-8 col-xs-offset-3" }, [
        _c("label", { attrs: { for: "online" } }, [
          _c("input", {
            attrs: { type: "checkbox", name: "online", id: "online", value: "" }
          }),
          _vm._v("\n              使我保持登录状态")
        ])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-400f42fc", module.exports)
  }
}

/***/ })

});