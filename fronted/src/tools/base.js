module.exports =  {
        /**
         * @property    {string}
         * 站点名称设置
         */
        webTitle: '',
        /**
         * @property    {string}
         * 站点目录
         */
        proPath: 'backend',//aries 
        /**
         * @property    {string}
         * 语言设置
         */
        language: localStorage.language || navigator.language || 'en',
        /**
         * @property    {string}
         * 版本号
         */
        version: '0.0.1',
        /**
         * @property    {string}
         */
        copyright: 'h5',
        /**
         * @property    {boolean}
         * 是否包含验证预处理机制
         */
        statsCompleteExist: true,
        /**
         * @property    {boolean}
         * 前端Debugger开关
         */
        frontendDebugger: false,
        /**
         * @property    {Number}
         * 前端Seesion 超时设置 [分钟]
         */
        seesionTimeout: 1440,
        /**
         * @property    {Number}
         * 前端 请求 超时设置 [分钟]
         */
        requestTimeout: 3,
        /**
         * @property {String}
         * 定义全局变量
         */
        network: 'GOOGLE',
        urlPrefix: {
        },
        errorCodeMap: {
            '100': '用户不可用',
            '101': '没有此用户',
            '102': '密码错误',
            '103': '验证码错误',
            '104': '无权限',
            '105': '操作失败',
            '106': '角色名重复',
            '999': '登录超时'
        }
    }
