// vue.config.js
module.exports = {
  // the directory where the production build files will be generated
  outputDir: '../public',
  // don't need source maps for production
  productionSourceMap: false,
  // more fine-grained modification of the internal webpack config.
  // chainWebpack: (config) => {
  //   config.plugin('copy').tap((options) => {
  //   });
  // },
};
