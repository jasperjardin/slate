import gulp from 'gulp';
import rename from 'gulp-rename';
import template from 'gulp-template';
import svg2ttf from 'gulp-svg2ttf';
import { svgicons2svgfont } from 'gulp-svgicons2svgfont';

const fontName = 'impulse-icons';

gulp.task('icons:format', () => {
	return gulp
		.src(['assets/resources/iconfont/icons/*.svg'], { encoding: false })
		.pipe(
			rename((path) => {
				path.basename = path.basename.replace(/icon[-=]/i, '');
			})
		)
		.pipe(gulp.dest('./dist/icons'));
});

gulp.task('icons:font:to-svg', function () {
	return svgicons2svgfont(['dist/icons/*.svg'], {
		fontName,
		normalize: true,
		fontHeight: 1001
	})
		.on('glyphs', (glyphs) => {
			gulp.src(['./assets/resources/iconfont/templates/**/*.scss'], { encoding: false })
				.pipe(
					template({
						glyphs: glyphs.map((glyph) => ({
							name: glyph.name,
							codepoint: glyph.unicode[0].charCodeAt(0).toString(16)
						})),
						fontName,
						version: Math.random().toString(36).substring(8),
						fontPath: '../../fonts/',
						className: 'icon',
					})
				)
				.pipe(gulp.dest('./assets/resources/css/'))
		})
		.pipe(gulp.dest('./dist/fonts/'))
});

gulp.task('icons:font:to-ttf', () => {
	return gulp.src(['dist/fonts/*.svg'], { encoding: false })
		.pipe(svg2ttf())
		.pipe(gulp.dest('dist/fonts/'));
});

gulp.task('icons', gulp.series('icons:format', 'icons:font:to-svg', 'icons:font:to-ttf'));
