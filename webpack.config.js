const path = require('path');
const sass = require('sass');
const CopyWebpackPlugin = require('copy-webpack-plugin');

async function sassRender(options) {
  const result = await sass.compileAsync(options.file, {
    style: 'compressed',
  });

  return {
    css: result.css,
  };
}

module.exports = () => {
  return {
    mode: 'production', // since you explicitly run build for production

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
              });
              return result.css.toString();
            },
          },
        ],
      }),
    ],
  };
};