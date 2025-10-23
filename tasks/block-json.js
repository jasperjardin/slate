import gulp from 'gulp';
import glob from 'glob';
import rename from 'gulp-rename';
import { reload } from './browsersync.js';
import eventStream from 'event-stream';

const blockJsonTasks = {};

// Loop through the block json files to make separate tasks/watches to optimize speed.
const blockSCSSFiles = glob.sync('./acf-blocks/**/src/block.json');
if (blockSCSSFiles) {
	blockSCSSFiles.forEach((file) => {
		const matches = file.match(/acf-blocks\/([a-zA-Z0-9\-]+)\//i);
		if (null !== matches) {
			const taskName = `block-json:${matches[1]}`;

			const fileDir = file.substring(0, file.lastIndexOf('/'));

			blockJsonTasks[taskName] = {
				src: fileDir + '/block.json',
				watch: [fileDir + '/block.json'],
			};
		}
	}, {});
}

function tsToJS(wpDefinedAsset) {
	if (wpDefinedAsset instanceof Array) {
		return wpDefinedAsset.map((asset) => asset.replace('.tsx', '.js').replace('.ts', '.js'));
	}

	return wpDefinedAsset.replace('.tsx', '.js').replace('.ts', '.js');
}

function editJSONFiles() {
	return eventStream.map((file, cb) => {
		const fileContent = file.contents.toString();
		const blockJson = JSON.parse(fileContent);

		if ('undefined' !== typeof blockJson.script) {
			blockJson.script = tsToJS(blockJson.script);
		}

		// update the vinyl file
		file.contents = new Buffer.from(JSON.stringify(blockJson));

		// send the updated file down the pipe
		cb(null, file);

		return file;
	});
}

// Create tasks
Object.entries(blockJsonTasks).forEach(([index, item]) => {
	gulp.task(index, () => {
		return gulp
			.src(item.src, { base: 'src/' })
			.pipe(editJSONFiles())
			.pipe(
				rename(function (file) {
					file.dirname = file.dirname.replace('/src', '/dist');
				})
			)
			.pipe(gulp.dest('dist/'))
			.pipe(reload({ stream: true }));
	});
});

// Create grouped tasks.
gulp.task('block-json', gulp.parallel(...Object.keys(blockJsonTasks)));

gulp.task('block-json:watch', (done) => {
	Object.entries(blockJsonTasks).forEach(([index, item]) => {
		gulp.watch(item.watch, gulp.series(index));
	});

	done();
});
