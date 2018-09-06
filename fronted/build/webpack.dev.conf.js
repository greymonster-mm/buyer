'use strict'
var utils = require('./utils')
var webpack = require('webpack')
var config = require('../config')
var merge = require('webpack-merge')
var baseWebpackConfig = require('./webpack.base.conf')
var HtmlWebpackPlugin = require('html-webpack-plugin')
var FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')
const path = require('path')

function getModuleName(module) 
{
  var sign = 'node_modules';
  
  var signIndex = module.resource.indexOf(sign);
  var pathSeparator = module.resource.slice(signIndex - 1, signIndex);
  var modulePath = module.resource.substring(signIndex + sign.length + 1);
  var moduleName = modulePath.substring(0, modulePath.indexOf(pathSeparator) );
  //_axios@0.16.2@axios
  var moduleNameArr = moduleName.split('@');
  moduleName = moduleNameArr[(moduleNameArr.length - 1)]
  moduleName = moduleName.toLowerCase();
  return moduleName
}

// add hot-reload related code to entry chunks
Object.keys(baseWebpackConfig.entry).forEach(function (name) {
  baseWebpackConfig.entry[name] = ['./build/dev-client'].concat(baseWebpackConfig.entry[name])
})

var chunks = ['manifest', 'axios', 'vue', 'vendor', 'element-ui', 'echarts', 'app']
module.exports = merge(baseWebpackConfig, {
  module: {
    rules: utils.styleLoaders({ sourceMap: config.dev.cssSourceMap })
  },
  // cheap-module-eval-source-map is faster for development
  devtool: 'cheap-module-eval-source-map',
  plugins: [
    new webpack.DefinePlugin({
      'process.env': config.dev.env
    }),
    // https://github.com/glenjamin/webpack-hot-middleware#installation--usage
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
    
    
    new HtmlWebpackPlugin({
        filename: config.build.index,
        template: 'index.html',
        inject: true,
        minify: {
          removeComments: true,
          collapseWhitespace: true,
          removeAttributeQuotes: true
          // more options:
          // https://github.com/kangax/html-minifier#options-quick-reference
        },
        // necessary to consistently work with multiple chunks via CommonsChunkPlugin
        chunks: chunks,
        chunksSortMode: function(a, b) {
          return chunks.indexOf(a.names[0]) - chunks.indexOf(b.names[0])
        },
      }),
    new FriendlyErrorsPlugin(),
 // split vendor js into its own file
    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      minChunks: function (module, count) {
        // any required modules inside node_modules are extracted to vendor
        return (
          module.resource &&
          /\.js$/.test(module.resource) &&
          module.resource.indexOf(
            path.join(__dirname, '../node_modules')
          ) === 0
        )
      },
    }),
    new webpack.optimize.CommonsChunkPlugin({
        name: 'axios',
        chunks: ['vendor'],
        minChunks: function (module, count) {
          return module.resource && ~['axios', 'qs', 'md5'].indexOf(getModuleName(module) ) && count >= 1
        }
	  }),
	  new webpack.optimize.CommonsChunkPlugin({
	    name: 'vue',
	    chunks: ['vendor'],
	    minChunks: function (module, count) {
	      return module.resource && ~['vue', 'vue-router'].indexOf(getModuleName(module) ) && count >= 1
	    }
	  }),
	  new webpack.optimize.CommonsChunkPlugin({
	    name: 'element-ui',
	    chunks: ['vendor'],
	    minChunks: function (module, count) {
	    	console.log(getModuleName(module))
	      return module.resource && ~['element-ui'].indexOf(getModuleName(module) ) && count >= 1
	    }
	  }),
    // extract webpack runtime and module manifest to its own file in order to
    // prevent vendor hash from being updated whenever app bundle is updated
    new webpack.optimize.CommonsChunkPlugin({
      name: 'manifest',
      chunks: ['vendor']
    }),
  ]
})
