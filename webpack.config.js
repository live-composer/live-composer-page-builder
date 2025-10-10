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
          {
            from: './css/src/frontend/',
            to: '../../css/dist/frontend.min.css', // relative to ./js/dist/
            async transform(content, filepath) {
              const result = await sassRender({
                file: filepath,
                outputStyle: 'compressed',
                sourceMapEmbed: !env.production,
              });
              return result.css.toString();
            },
          },
          {
            from: './css/src/builder/',
            to: '../../css/dist/builder.min.css', // relative to ./js/dist/
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
