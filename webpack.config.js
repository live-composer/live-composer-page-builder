const path = require('path');
const sass = require('sass');  // Dart Sass
const util = require('util');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const sassRender = util.promisify(sass.render);

module.exports = (env = {}) => {
  return {
    mode: env.production ? 'production' : 'development',
    devtool: 'cheap-source-map',
    entry: {
      editor_backend: './js/src/editor/backend/index.js',
      editor_frontend: './js/src/editor/frontend/index.js',
      client_backend: './js/src/client/backend/index.js',
      client_frontend: './js/src/client/frontend/index.js',
    },
    output: {
      filename: '[name].min.js',
      path: path.resolve(__dirname, './js/dist'),
    },
    module: {
      rules: [
        {
          test: /\.scss$/,  // or /\.sass$/ or /\.css$/ depending on your files
          use: [
            'style-loader',  // inject CSS to DOM
            'css-loader',    // translate CSS into CommonJS
            'sass-loader',   // compile Sass to CSS
          ],
        },
      ],
    },
    plugins: [
      new CopyWebpackPlugin({
        patterns: [
          // 1. FRONTEND CORE CSS: Target the single file (Fixed the directory-to-file bug)
          {
            from: './css/src/frontend/index.css', 
            to: '../../css/dist/frontend.min.css', 
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },
          
          // 2. FRONTEND PLUGINS CSS: Added to compile frontend plugin styles.
          // NOTE: If this file does not exist, you must create an empty file named plugins.css in the source folder.
          {
            from: './css/src/frontend/plugins.css', 
            to: '../../css/dist/frontend.plugins.min.css',
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },

          // 3. BUILDER CORE CSS: Target the single file (Fixed the directory-to-file bug)
          {
            from: './css/src/builder/index.css', 
            to: '../../css/dist/builder.min.css', 
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },
          
          // 4. BUILDER PLUGINS CSS: Added to compile builder plugin styles.
          // NOTE: If this file does not exist, you must create an empty file named plugins.css in the source folder.
          {
            from: './css/src/builder/plugins.css', 
            to: '../../css/dist/builder.plugins.min.css',
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },
          // 4. BUILDER PLUGINS CSS: Added to compile builder plugin styles.
          // NOTE: If this file does not exist, you must create an empty file named font-awesome.css in the source folder.
          {
            from: './css/font-awesome.css', 
            to: '../../css/font-awesome.min.css',
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },
        ],
      }),
    ],
  };
};