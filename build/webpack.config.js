//
// Web pack configuration
//
// ========================================================================

const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const fs = require('fs');

function prepareEntry(source, mode) {
	const entry = {};

	Object.keys(source).forEach((k, i) => {
		let key = k.replace(/^js\//, ''),
			data = JSON.parse(JSON.stringify(source[k]));

		let bundle = (typeof data === 'object' && data.import) ? data : {import: data};
		if (!Array.isArray(bundle.import)) {
			bundle.import = [bundle.import];
		}

		let imports = [];
		bundle.import.forEach((item) => {
			if (typeof item !== 'string') {
				imports.push(item);

				return;
			}

			let itemPath = path.resolve(__dirname, item);
			if (!(fs.existsSync(itemPath) && fs.statSync(itemPath).isDirectory())) {
				imports.push(item);

				return;
			}

			fs.readdirSync(item).forEach((file) => {
				imports.push(item + '/' + file);
			})
		})
		bundle.import = imports;

		let isArtifact = !bundle.import.some(item => {
			if (typeof item !== 'string') {
				return false;
			}

			item = item.toLowerCase();

			return item.endsWith('.js') || item.endsWith('.es6');
		});

		if (!bundle.filename) {
			bundle.filename = (!isArtifact) ? key + '.js' : key;
		}

		if (isArtifact) {
			if (!bundle.filename.endsWith('.artifact')) {
				bundle.filename += '.artifact';
			}
		} else {
			if (bundle.filename.endsWith('.min.js')) {
				bundle.filename = bundle.filename.slice(0, -7) + '.js';
			} else if (!bundle.filename.endsWith('.js')) {
				bundle.filename += '.js';
			}

			if (mode === 'production' && bundle.filename.endsWith('.js')) {
				bundle.filename = bundle.filename.slice(0, -3) + '.min.js';
			}
		}

		if (!bundle.filename.startsWith('js/')) {
			bundle.filename = 'js/' + bundle.filename;
		}

		let entrypoint = key.replace(/\.(.?)*$/, '');
		if (entry[entrypoint]) {
			entrypoint = entrypoint + '_' + i;
		}

		entry[entrypoint] = bundle;
	});

	return entry;
}

function webpackConfig(entry, publicPath, mode) {
	if (!publicPath) {
		publicPath = './';
	}

	if (!mode) {
		mode = 'production';
	}

	let isProduction = (mode === 'production')

	return {
		mode: (isProduction) ? 'production' : 'development',
		entry: prepareEntry(entry, mode),
		output: {
			path: path.resolve(__dirname, publicPath),
		},
		devtool: (isProduction) ? false : 'inline-source-map',
		optimization: {
			minimize: isProduction,
			minimizer: (!isProduction) ? [] : [
				new TerserPlugin({
					test: /\.js(\?.*)?$/i,
					parallel: true,
					terserOptions: {
						keep_classnames: true,
						keep_fnames: true,

						compress: {
							pure_getters: true,
							unsafe_comps: true,
							unsafe: true,
							passes: 2,
							keep_fargs: false,
							drop_console: true
						},
						output: {
							beautify: false,
							comments: false,
						},
					},
					extractComments: false,
				}),
			]
		},
		module: {
			rules: [
				{
					test: /\.(es6|js)$/,
					type: 'javascript/auto'
				},
				{
					test: /\.(css|sass|scss)$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								sourceMap: !isProduction,
							},
						},
						{
							loader: 'sass-loader',
							options: {
								sourceMap: !isProduction,
							},
						}
					],
				},
				{
					test: /\.(woff|woff2)$/,
					type: 'asset/resource',
					generator: {
						filename: 'fonts/[name][ext]',
						publicPath: '../fonts/'
					}
				},
				{
					test: /\.(gif|png|jpe?g)$/,
					type: 'asset/resource',
					generator: {
						filename: 'images/[name][ext]',
						publicPath: '../images/'
					},
					use: [
						{
							loader: ImageMinimizerPlugin.loader,
							options: {
								minimizer: {
									implementation: ImageMinimizerPlugin.sharpMinify
								}
							}
						},
					],
				},
				{
					test: /\.(svg)$/,
					type: 'asset/resource',
					generator: {
						filename: 'images/[name][ext]',
						publicPath: '../images/'
					},
					use: [
						{
							loader: ImageMinimizerPlugin.loader,
							options: {
								minimizer: {
									implementation: ImageMinimizerPlugin.svgoMinify
								}
							}
						},
					],
				}
			]
		},
		plugins: [
			{
				apply: compiler => {
					/**
					 * @param {import('webpack').Compiler} compiler
					 */
					compiler.hooks.afterEmit.tap('RemoveArtifactFilesPlugin', () => {
						let directories = [compiler.options.output.path];

						while (directories.length > 0) {
							let directory = directories.pop(),
								entries = fs.readdirSync(directory, {withFileTypes: true});

							entries.forEach(entry => {
								let fullPath = path.join(directory, entry.name);

								if (entry.isDirectory()) {
									directories.push(fullPath);
									return;
								}

								if (entry.isFile() && entry.name.endsWith('.artifact')) {
									fs.rmSync(fullPath, {force: true});
								}
							});
						}
					});
				}
			},
			new MiniCssExtractPlugin({
				filename: (isProduction) ? 'css/[name].min.css' : 'css/[name].css',
				chunkFilename: (isProduction) ? 'css/[name].min.css' : 'css/[name].css',
			}),
		],
	}
}

module.exports = webpackConfig;