import TerserPlugin from 'terser-webpack-plugin';
import ESLintPlugin from 'eslint-webpack-plugin';
import path from 'path';

import GenerateAssetPhp from './webpack/GenerateAssetPhp.js';
import getScriptsFromJson from './webpack/getScriptsFromJson.js';
import webpack from 'webpack';
import { fileURLToPath } from 'url';
import glob from 'fast-glob';

const generateWebpackConfig = () => {
	const PROD = process.env.NODE_ENV === 'production';

	const __filename = fileURLToPath(import.meta.url);
	const __dirname = path.dirname(__filename);

	// Get entries from assets/resources/js/**/script.ts(x)
	const files = glob.sync('./assets/resources/js/**/script.ts?(x)');
	let entries = files.reduce((acc, file) => {
		const outputPath = file
			.replace('./assets/resources/js', './dist/js')
			.replace(/\.(ts|tsx)$/, '');
		acc[outputPath] = file;
		return acc;
	}, {});

	// Get block files to generate from block.json config.
	const blockJsFiles = getScriptsFromJson('./acf-blocks/**/block.json');

	if (blockJsFiles) {
		const blockEntries = blockJsFiles.reduce((prev, current) => {
			prev[current[0].replace('src', 'dist').replace('.js', '').replace('.tsx', '').replace('.ts', '')] = current;
			return prev;
		}, {});

		entries = {
			...blockEntries,
			...entries,
		};
	}

	const componentJsFiles = getScriptsFromJson('./components/**/manifest.json');

	if (componentJsFiles) {
		const componentEntries = componentJsFiles.reduce((prev, current) => {
			prev[current[0].replace('src', 'dist').replace('.js', '').replace('.tsx', '').replace('.ts', '')] = current;
			return prev;
		}, {});

		entries = {
			...componentEntries,
			...entries,
		};
	}

	return {
		entry: entries,
		output: {
			path: path.resolve(__dirname, '..'),
		},
		plugins: PROD
			? [
				new GenerateAssetPhp(),
				new webpack.ProvidePlugin({
					$: 'jquery',
					jQuery: 'jquery',
					Window: path.resolve(__dirname, '../assets/resources/js/global.d.ts'),
				}),
			]
			: [
				new ESLintPlugin({
					failOnError: false,
					fix: false,
				}),
				new GenerateAssetPhp(),
				new webpack.ProvidePlugin({
					$: 'jquery',
					jQuery: 'jquery',
					Window: path.resolve(__dirname, '../assets/resources/js/global.d.ts'),
				}),
			],
		devtool: PROD ? 'source-map' : 'eval-source-map',
		mode: PROD ? 'production' : 'development',
		module: {
			rules: [
				{
					test: /\.(js|ts|tsx)$/,
					exclude: /node_modules/,
					use: ['babel-loader'],
				},
			],
		},
		optimization: PROD
			? {
				minimize: true,
				minimizer: [new TerserPlugin()],
			}
			: {},
		resolve: {
			extensions: ['.js', '.ts', '.tsx'],
			alias: {
				"@globals": path.resolve(__dirname, "../assets/resources/js/globals"),
			},
		},
		externals: {
			jquery: 'jQuery',
		},
	};
}

export default generateWebpackConfig;
