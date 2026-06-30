const entry = {
	"com_radicalmart/radicalmart": {
		import: './tpl_radicalmart_uikit/es6/com_radicalmart/radicalmart.es6'
	},
};

const webpackConfig = require('./webpack.config.js');
const publicPath = '../tpl_radicalmart_uikit/media';
const production = webpackConfig(entry, publicPath);
const development = webpackConfig(entry, publicPath, 'development');

module.exports = [production, development]