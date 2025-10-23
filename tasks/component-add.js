import gulp from 'gulp';
import inquirer from 'inquirer';
import template from 'gulp-template';
import { cleanForSlug } from '@wordpress/url';
import fs from 'fs-extra'; // For creating directories if needed

function sanitizeTitle(string) {
    let output = cleanForSlug(string);
    output = output.replace(/--/g, '-');

    return output;
}

gulp.task('component-add', async function (done) {
    try {
        // Prompt user for the component title using Inquirer.js
        const responses = await inquirer.prompt([
            {
                type: 'input',
                name: 'title',
                message: 'Title: ',
                validate: (input) => input.trim() !== '' || 'The title cannot be blank',
            },
        ]);

        // Sanitize the title and create the component directory name
        const name = sanitizeTitle(responses.title);
        const partialDir = `./components/${name}/`;

        // Set name for templates
        responses.name = name;

        // Ensure the target directory exists
        fs.ensureDirSync(partialDir);

        // Replace variables in the templates and output the files
        return gulp.src('./tasks/templates/component/**/*.{ts,json,scss,php}')
            .pipe(template(responses))
            .pipe(gulp.dest(partialDir));
    } catch (error) {
        console.error('An error occurred:', error);
        done();
    }
});
