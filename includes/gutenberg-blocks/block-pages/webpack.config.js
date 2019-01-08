module.exports = {
  entry: {
    app: './block.js',
  },
	output: {
		path: __dirname,
		filename: 'block.build.js',
	},
	module: {
		rules: [
			{
				test: /.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/,
			},
		],
	},
};