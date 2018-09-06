'use strict'
var path = require('path')
var utils = require('./utils')
var webpack = require('webpack')
var config = require('../config/index.js')
var merge = require('webpack-merge')
var baseWebpackConfig = require('./webpack.base.conf')
var CopyWebpackPlugin = require('copy-webpack-plugin')
var HtmlWebpackPlugin = require('html-webpack-plugin')
var ExtractTextPlugin = require('extract-text-webpack-plugin')
var OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

var env = config.build.env
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

var chunks = ['manifest', 'axios', 'vue', 'vendor', 'element-ui', 'echarts', 'app']
var webpackConfig = merge(baseWebpackConfig, {
  module: {
    rules: utils.styleLoaders({
      sourceMap: config.build.productionSourceMap,
      extract: true
    })
  },
  devtool: config.build.productionSourceMap ? '#source-map' : false,
  output: {
    path: config.build.assetsRoot,
    filename: utils.assetsPath('js/[name].[chunkhash:8].js'),
    chunkFilename: utils.assetsPath('js/[id].[chunkhash:8].js')
  },
  plugins: [
    // http://vuejs.github.io/vue-loader/en/workflow/production.html
    new webpack.DefinePlugin({
      'process.env': env
    }),
    // generate dist index.html with correct asset hash for caching.
    // you can customize output by editing /index.html
    // see https://github.com/ampedandwired/html-webpack-plugin
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
    // extract css into its own file
    new ExtractTextPlugin({
      filename: utils.assetsPath('css/[name].[contenthash].css')
    }),
    // Compress extracted CSS. We are using this plugin so that possible
    // duplicated CSS from different components can be deduped.
    new OptimizeCSSPlugin({
      cssProcessorOptions: {
        safe: true
      }
    }),
    // copy custom static assets
    new CopyWebpackPlugin([
      {
        from: path.resolve(__dirname, '../static'),
        to: config.build.assetsSubDirectory,
        ignore: ['.*']
      }
    ]),
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
    
    new UglifyJsPlugin({
	    uglifyOptions: {
	      mangle: {
	        safari10: true
	      }
	    },
	    sourceMap: config.build.productionSourceMap,
	    cache: true,
	    parallel: true
	  })
  ]
})

if (config.build.productionGzip) {
  var CompressionWebpackPlugin = require('compression-webpack-plugin')

  webpackConfig.plugins.push(
    new CompressionWebpackPlugin({
      asset: '[path].gz[query]',
      algorithm: 'gzip',
      test: new RegExp(
        '\\.(' +
        config.build.productionGzipExtensions.join('|') +
        ')$'
      ),
      threshold: 10240,
      minRatio: 0.8
    })
  )
}

if (config.build.bundleAnalyzerReport) {
  var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
  webpackConfig.plugins.push(new BundleAnalyzerPlugin({
      analyzerMode: 'static',
      reportFilename: 'bundle-report.html',
      openAnalyzer: false
    }))
}

module.exports = webpackConfig
