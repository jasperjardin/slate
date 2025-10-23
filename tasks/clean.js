import gulp from 'gulp';
import del from 'del';

gulp.task('clean', () => {
	return del(['./dist/', './acf-blocks/**/dist', './template-parts/**/dist']);
});
