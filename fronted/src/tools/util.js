/**
 * 工具类
 **/


var $ = require('jquery');
var util = {
    /**
     * @method
     * 日期格式化
     * @param   {Object/number} date        日期对象或毫秒
     * @param   {string}        [format]    格式化字符串
     * @param   {number}        [range]     返回值根据此参数向前或向后计算日期，以“天”为单位
     *
     * @return  {string}    根据格式化字符串格式化之后的日期
     */
    formatDate: function(date, format, range, utc) {
        var ms, sourceDate = date;
        if (date) {
            date = new Date(date);
            if (isNaN(date - 0)) {
                ms = Number(sourceDate);
                if (!isNaN(ms)) {
                    date = new Date(ms);
                } else {
                    date = new Date();
                }
            }
        } else if (typeof date === 'undefined' || date === null) {
            return '-';
        } else {
            date = new Date();
        }
        // 数据容错
        if (typeof format === 'number') {
            range = format;
            format = null;
        }
        format = format || 'YYYY/MM/DD hh:mm:ss';
        if (typeof range === 'number') {
            date = new Date(date - 0 + (range * 24 * 60 * 60 * 1000));
        }
        // 补充0
        function prefixZero(num) {
            if (num < 10) {
                return 0 + num;
            }
            return num;
        }

        var year = date.getFullYear() + '',
            month = date.getMonth() + 1 + '',
            day = date.getDate() + '',
            hours = date.getHours() + '',
            minutes = date.getMinutes() + '',
            seconds = date.getSeconds() + '',
            //utc time
            pY = /Y+/.exec(format), // 匹配年份
            pM = /M+/.exec(format), // 匹配月份
            pD = /D+/.exec(format), // 匹配日期
            ph = /h+/.exec(format), // 匹配小时
            pm = /m+/.exec(format), // 匹配分钟
            ps = /s+/.exec(format); // 匹配秒
        if (!utc) {
            year = date.getUTCFullYear() + '',
                month = date.getUTCMonth() + 1 + '',
                day = date.getUTCDate() + '',
                hours = date.getUTCHours() + '',
                minutes = date.getUTCMinutes() + '',
                seconds = date.getUTCSeconds() + '';
        }
        // 年份替换
        if (pY) {
            if (pY[0].length === 2) {
                year = year.slice(2);
            }
            format = format.replace(pY[0], year);
        }
        // 月份替换
        if (pM) {
            if (pM[0].length === 2) {
                month = prefixZero(month);
            }
            format = format.replace(pM[0], month);
        }
        // 日期替换
        if (pD) {
            if (pD[0].length === 2) {
                day = prefixZero(day);
            }
            format = format.replace(pD[0], day);
        }
        // 小时替换
        if (ph) {
            if (ph[0].length === 2) {
                hours = prefixZero(hours);
            }
            format = format.replace(ph[0], hours);
        }
        // 分钟替换
        if (pm) {
            if (pm[0].length === 2) {
                minutes = prefixZero(minutes);
            }
            format = format.replace(pm[0], minutes);
        }
        // 秒数替换
        if (ps) {
            if (ps[0].length === 2) {
                seconds = prefixZero(seconds);
            }
            format = format.replace(ps[0], seconds);
        }
        return format;
    },
}
module.exports = util;
