import gulp from 'gulp';
import inquirer from 'inquirer';
import template from 'gulp-template';
import { cleanForSlug } from '@wordpress/url';
import fs from 'fs-extra';

function sanitizeTitle(string) {
	let output = cleanForSlug(string);
	output = output.replace(/--/g, '-');

	return output;
}

gulp.task('block-add', async function (done) {
	try {
		// Prompt user for inputs using Inquirer.js
		const responses = await inquirer.prompt([
			{
				type: 'input',
				name: 'title',
				message: 'Title: ',
				validate: (input) => input.trim() !== '' || 'The title cannot be blank',
			},
			{
				type: 'input',
				name: 'icon',
				message: 'Icon (https://developer.wordpress.org/resource/dashicons, svg): ',
				validate: (input) => input.trim() !== '' || 'The icon cannot be blank',
			},
			{
				type: 'input',
				name: 'category',
				message: 'Category (text, media, embed, etc): ',
				validate: (input) => input.trim() !== '' || 'The category cannot be blank',
			},
		]);

		// Sanitize the title and create block directory name
		const name = sanitizeTitle(responses.title);
		const blockDir = `./acf-blocks/${name}/`;

		// Set name for templates
		responses.name = name;

		// Ensure the target directory exists
		fs.ensureDirSync(blockDir);

		// Replace variables in the templates and output the files
		return gulp.src('./tasks/templates/acf-block/**/*.*')
			.pipe(template(responses))
			.pipe(gulp.dest(blockDir));
	} catch (error) {
		console.error('An error occurred:', error);
		done();
	}
});
