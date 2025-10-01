const path = require('path');
const sass = require('node-sass');
const CopyWebpackPlugin = require('copy-webpack-plugin');

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
          test: /\.(js|jsx)$/,
          exclude: /(node_modules|bower_components)/,
          use: {
            loader: 'babel-loader',
            options: {
              cacheDirectory: true,
            },
          },
        },
      ],
    },
    plugins: [
      new CopyWebpackPlugin({
        patterns: [
          {
            from: './css/src/frontend/',
            to: '../../css/dist/frontend.min.css', // relative to ./js/dist/
            transform(content, path) {
              const result = sass.renderSync({
                file: path,
                outputStyle: 'compressed',
                sourceMapEmbed: env.production ? false : true,
              });

              return result.css.toString();
            },
          },
          {
            from: './css/src/builder/',
            to: '../../css/dist/builder.min.css', // relative to ./js/dist/
            transform(content, path) {
              const result = sass.renderSync({
                file: path,
                outputStyle: 'compressed',
                sourceMapEmbed: env.production ? false : true,
              });

              return result.css.toString();
            },
          },
        ],
      }),
    ],
  };
};
