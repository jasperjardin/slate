import gulp from 'gulp';
import dotenv from 'dotenv';
import yargs from 'yargs';
import { hideBin } from 'yargs/helpers';

dotenv.config();

const argv = yargs(hideBin(process.argv)).argv;
if (argv.prod) {
	process.env.NODE_ENV = 'production';
}

import './tasks/clean.js';
import './tasks/scripts.js';
import './tasks/styles.js';
import './tasks/block-add.js';
import './tasks/component-add.js';
import './tasks/block-json.js';
import './tasks/browsersync.js';
import './tasks/icons.js';
import './tasks/css-variables.js';

gulp.task(
	'default',
	gulp.series('clean', 'css-vars', 'block-json', 'icons', gulp.parallel('styles', 'scripts'))
);

gulp.task(
	'watch',
	gulp.series(
		gulp.parallel('css-vars:watch', 'styles:watch', 'scripts:watch', 'block-json:watch')
	)
);

gulp.task('serve', gulp.series('watch', 'browserSync'));
