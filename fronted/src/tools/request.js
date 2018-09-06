var config = require('./base.js')
var Promise = require('promise-polyfill')
import axios from 'axios'
var urlPrefix = {
    /**
     * @property    {Object}    prefix
     * URL前缀
     * @property    {string}    prefix.root     根目录
     */
  prefix: {
        // 根目录
    getGoodsIntro : getRequestPrefix('index.php?m=index&c=good&a=getGoodsIntro'),
    getGood : getRequestPrefix('index.php?m=index&c=good&a=getGoodById'),
    getCategoryList : getRequestPrefix('index.php?m=index&c=category&a=getCategoryChilds'),
    getCategoryParents: getRequestPrefix('index.php?m=index&c=category&a=getCategoryParents'),
    getCategoryTree: getRequestPrefix('index.php?m=index&c=category&a=getCategoryTree'),
    addGood: getRequestPrefix('index.php?m=index&c=good&a=addGood'),
    deleteGood: getRequestPrefix('index.php?m=index&c=good&a=deleteGood'),
    updateGood: getRequestPrefix('index.php?m=index&c=good&a=updateGood'),
    deleteCategoryTree: getRequestPrefix('index.php?m=index&c=category&a=deleteCategoryTree'),
    addCategoryTree: getRequestPrefix('index.php?m=index&c=category&a=addCategoryTree'),
    auth: getRequestPrefix('index.php?m=index&c=auth&a=token'),
    checkProductName : getRequestPrefix('index.php?m=index&c=good&a=checkProductName'),
    addSendTimes : getRequestPrefix('index.php?m=index&c=good&a=addSendTimes')
  },
    /**
     * @property    {string}    suffix
     * URL后缀
     */
  suffix: '' //    .json
}

/**
 * @method
 * 获取请求URL前缀
 * @private
 * @param   {string}    path    前缀路径
 * @param   {string}    root    根目录
 *
 * @return  {string}    基于网站根目录的前缀路径
 */
function getRequestPrefix (path, root) {
  var rootPath = config.proPath
  root = root || location.protocol + "//" + location.hostname + ":" + location.port + '/';
  return root + (rootPath ? rootPath + '/' : '') + (path ? path : '');
}


/**
 * @method
 * 获取Ajax完整URL。
 * @private
 * @param   {string}    url                 请求基准URL
 * @param   {string}    [webType='root']     请求类型
 * @param   {string}    [suffix='json']     后缀名称
 *
 * @return  {string}    请求的完整URL
 */
function getAjaxUrl(url) {
    //绝对地址直接返回
    var prefix = urlPrefix.prefix;
    return prefix[url];
}

function sessionTimeout(that, code) {
    // 会话是否过期
    if (/*code == '104' || */ code == '999') {
        console.warn('Code is ' + code + ',Please Call youself');
        localStorage.removeItem("UUIDSEESION");
        // 跳转到登陆页面
        that.$router.push("/login");
        return true;
    }
}

//vue 请求插件开发
export default {
    install: function (Vue, options) {
        // 添加实例方法
        // Vue.prototype._tool = {};
        Vue.prototype._httpRequest = function (options, callback) {
            var that = this;
            var _timeout = config.requestTimeout * 60 * 1000;
            options.type = options.type ? options.type.toUpperCase() : 'POST';
            options.params = typeof options.params === 'undefined' ? {} : options.params;
            if (localStorage.getItem("access_token"))
            {
            	options.params.access_token = JSON.parse(localStorage.getItem("access_token"))
            }
            //缺少并发处理 TODO
            return new Promise(function (resolve, reject) {
                var CancelToken = axios.CancelToken;
                var source = CancelToken.source();
                axios({
                    method: options.type,
                    url: getAjaxUrl(options.url),
                    // url:'./index.php/home/'+ options.webType + "/" + options.url,
                    timeout: _timeout,
                    responseType: 'json',
                    data: options.params
                }).then(function (response) {
                	if (response.error && response.error == 'Unauthenticated.') {
                        localStorage.removeItem("access_token");
                        // 跳转到登陆页面
                        that.$router.push("/Login");
                        return;
                    }                    const _data = response.data;
                    if (!_data) {
                        // 错误回调
                        reject(_data);
                    }
                    if (_data.errorcode) {
                        // 检查会话是否过期
                        if (sessionTimeout(that, _data.errorcode)) {
                            reject(_data);
                        }
                    }
                    resolve(_data);
                }).catch(error => {
                    //网络异常，及请求中断
                    //todo 需分别处理
                    if (error.code == 'ECONNABORTED' && error.message.indexOf('timeout') >= 0) {
                        that.$Message.error("Request timeout");
                    }else if (error.response) {
                        if (error.response.status.toString() != "401") {
                            that.$message({
                                message: '发生异常错误,请刷新页面重试',
                                type: 'error',
                                iconClass: '',
                                duration: 5 * 1000
                            });
                        } else if (error.response.status.toString() == "401" && error.response.statusText.toString() == 'Unauthorized') {
                            localStorage.removeItem("access_token");
                            // 跳转到登陆页面
                            that.$router.push("/Login");
                        }
                    } else {
                        that.$Message.error("发生异常错误,请刷新页面重试");
                    }
                    reject(error);
                });
            })
        }
        // 添加实例方法
        Vue.prototype._httpGetUrl = function (url, webType, suffix) {
            return getAjaxUrl(url, webType, suffix);
        }
        //获取codemap映射
        Vue.prototype._httpErrorCodeMap = function (code) {
            return config.errorCodeMap[code];
        }
        // 1. 添加全局方法或属性
        // Vue.prototype.httploading = false;
        Vue.mixin({
            data(){
                return {
                    httploading:false
                };
            }
        })
    }
};
