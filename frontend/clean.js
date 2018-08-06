// clean up `dist` directory using custom method
// and disable by `vue-cli-service build --no-clean`
const fs = require('fs');
const path = require('path');
const util = require('util');
const rimraf = require('rimraf');
const vueConfig = require('./vue.config');
const excludeFiles = require('./clean.exclude');
const { error, info, warn, done } = require('@vue/cli-shared-utils');


const rm = util.promisify(rimraf);
const lstat = util.promisify(fs.lstat);
const readdir = util.promisify(fs.readdir);


class CleanService {

  static async cleanup(excludeFiles) {
    return new Promise(async (resolve, reject) => {
      const outputDir = path.resolve(vueConfig.outputDir);
      let names = await readdir(outputDir);

      for (let name of names) {
        if (excludeFiles.indexOf(name) === -1) {
          let absolutePath = `${outputDir}/${name}`;
          info(`Remove file ${absolutePath}`);
          await rm(absolutePath);
        }
      }

      done('Clean success');
      resolve();
    })
  }

}


CleanService.cleanup(excludeFiles).catch(err => {
  error(err);
  process.exit(1);
});
