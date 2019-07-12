const path = require('path');
const sass = require( 'node-sass' );
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = ( env = {} ) => {
	return {
		mode: (() => {
			if ( env.production ) return 'production'
			else return 'development'
		})(),
		devtool: 'cheap-source-map',
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
			],
		},

		plugins: [
			new CopyWebpackPlugin([
				{
					from: './css/src/frontend/',
					to: '../../css/dist/frontend.min.css', // relative to ./js/dist/

					transform: ( content, path ) => {
						// CopyWebpackPlugin - simply copies files over.
						// transform - perform actions over files while copping.

						// 1. Compile SCSS into CSS with https://github.com/sass/node-sass
						const result = sass.renderSync({
							file: path,
							outputStyle: 'compressed',
							sourceMapEmbed: (() => {
								if ( env.production ) return false
								else return true
							})(),
						  });

						// 2. Prepare result:
						const css = result.css.toString();
						return css;
					},
				}
			]),

			new CopyWebpackPlugin([
				{
					from: './css/src/builder/',
					to: '../../css/dist/builder.min.css', // relative to ./js/dist/

					transform: ( content, path ) => {
						// CopyWebpackPlugin - simply copies files over.
						// transform - perform actions over files while copping.

						// 1. Compile SCSS into CSS with https://github.com/sass/node-sass
						const result = sass.renderSync({
							file: path,
							outputStyle: 'compressed',
							sourceMapEmbed: (() => {
								if ( env.production ) return false
								else return true
							})(),
						  });

						// 2. Prepare result:
						const css = result.css.toString();
						return css;
					},
				}
			]),
		]
	};
};
