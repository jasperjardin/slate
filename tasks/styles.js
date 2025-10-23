import gulp from 'gulp';
import glob from 'glob';
import cleanCSS from 'gulp-clean-css';
import rename from 'gulp-rename';
import gulpStylelint from '@ronilaukkarinen/gulp-stylelint';
import path from 'path';
import fs from 'fs';

import * as dartSass from 'sass'
import gulpDartSass from 'gulp-sass';
const sass = gulpDartSass(dartSass);

const PROD = process.env.NODE_ENV === 'production';

const styleTasks = {
	'styles:theme': {
		src: './assets/resources/css/**/style.scss',
		watch: ['./assets/resources/css/**/*.scss', '!./assets/resources/css/vendor/**/*.scss', './assets/resources/css/*.scss'],
	},
};

// Loop through the block css files to make separate tasks/watches to optimize speed.
const blockSCSSFiles = glob.sync('./acf-blocks/**/*.scss');
if (blockSCSSFiles) {
	blockSCSSFiles.forEach((file) => {
		const matches = file.match(/acf-blocks\/([a-zA-Z0-9\-]+)\//i);
		if (null !== matches) {
			const taskName = `styles:block:${matches[1]}`;

			const fileDir = file.substring(0, file.lastIndexOf('/'));

			styleTasks[taskName] = {
				src: fileDir + '/*.scss',
				watch: [
					file.substring(0, file.lastIndexOf('/')) + '/**/*.scss',
					'assets/resources/css/helpers/**.scss',
				],
			};
		}
	}, {});
}

const componentSCSSFiles = glob.sync('./components/**/*.scss');
if (componentSCSSFiles) {
	componentSCSSFiles.forEach((file) => {
		const matches = file.match(/components\/([a-zA-Z0-9\-]+)\//i);
		if (null !== matches) {
			const taskName = `styles:component:${matches[1]}`;

			const fileDir = file.substring(0, file.lastIndexOf('/'));

			styleTasks[taskName] = {
				src: fileDir + '/*.scss',
				watch: [
					file.substring(0, file.lastIndexOf('/')) + '/**/*.scss',
					'assets/resources/css/helpers/**.scss',
				],
			};
		}
	}, {});
}

const date = new Date();
const time = date.getTime();

// Create css tasks
Object.entries(styleTasks).forEach(([index, item]) => {
	gulp.task(index, () => {
		return gulp.src(item.src, { base: '.', sourcemaps: !PROD })
			.pipe(
				gulpStylelint({
					fix: false,
					failAfterError: false,
					reporters: [{ formatter: 'string', console: true }],
				})
			)
			.pipe(
				sass({
					loadPaths: ['assets/resources/css']
				}).on('error', function (err) {
					console.info('Sass Error:', err.messageFormatted);
					this.emit('end');
				})
			)
			.pipe(cleanCSS())
			.pipe(
				rename(function (file) {
					file.dirname = file.dirname
						.replace('assets/resources/css', 'dist/css')  // theme CSS
						.replace('/src/css', '/dist/css');            // blocks/components
				})
			)
			.pipe(
				gulp.dest('.', {
					sourcemaps: !PROD,
				})
			);
	});

	gulp.task(`${index}:stylelint`, () => {
		const lastRun = gulp.lastRun(`${index}:stylelint`)
			? gulp.lastRun(`${index}:stylelint`)
			: time;

		return gulp.src(item.watch, { base: '.', since: lastRun }).pipe(
			gulpStylelint({
				fix: false,
				failAfterError: false,
				reporters: [{ formatter: 'string', console: true }],
			})
		);
	});
});

// Create grouped tasks.
gulp.task('styles', gulp.parallel(...Object.keys(styleTasks)));

gulp.task('styles:watch', (done) => {
	Object.entries(styleTasks).forEach(([index, item]) => {
		gulp.watch(item.watch, gulp.series(index, `${index}:stylelint`));
	});

	done();
});
