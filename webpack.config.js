const path = require('path');

module.exports = {
	mode: 'development',
	entry: {
		editor_backend: './js/src/editor/backend/index.js',
		editor_frontend: './js/src/editor/frontend/index.js',

		client_backend: './js/src/client/backend/index.js',
		client_frontend: './js/src/client/frontend/index.js'
	},
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, './js/dist')
	},
	devtool: 'cheap-source-map',
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						// This is a feature of `babel-loader` for webpack (not Babel itself).
						// It enables caching results in ./node_modules/.cache/babel-loader/
						// directory for faster rebuilds.
						cacheDirectory: true,
					},
				},
			},
			/* {
				test: /style\.s?css$/,
				exclude: /(node_modules|bower_components)/,
				use: blocksCSSPlugin.extract( extractConfig ),
			},
			{
				test: /editor\.s?css$/,
				exclude: /(node_modules|bower_components)/,
				use: editBlocksCSSPlugin.extract( extractConfig ),
			}, */
		],
	},
  /* output: {
    filename: '[name].js',
    path: __dirname + '/dist'
  } */
};