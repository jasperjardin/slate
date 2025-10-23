import webpack from 'webpack';
import gulp from 'gulp';

import generateWebpackConfig from './generate-webpack-config.js';

gulp.task('scripts', (done) => {
	const webpackConfig = generateWebpackConfig();
	webpack(webpackConfig, (err, stats) => {
		if (stats) {
			// eslint-disable-next-line no-console
			console.info(stats.toString());
		}

		if (stats.hasErrors()) {
			// Break Gulp execution:
			return new Promise((resolve, reject) => {
				reject('Script build contained errors.');
			});
		}

		done();
	});
});

gulp.task('scripts:watch', (done) => {
	const webpackConfig = generateWebpackConfig();
	webpack({ ...webpackConfig, watch: true }, (err, stats) => {
		// eslint-disable-next-line no-console
		console.info(stats.toString());
	});

	done();
});
