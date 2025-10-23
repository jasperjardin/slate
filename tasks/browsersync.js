import gulp from 'gulp';
import browserSync from 'browser-sync';

const bsInstance = browserSync.create();

gulp.task('browserSync', () => {
    bsInstance.init({
        proxy: process.env.APP_URL,
        injectChanges: false,
    });

    // Watch files and reload browser on change
    gulp.watch(['**/*.php', '!vendor', 'dist/**/*.{css,js}', '**/dist/**/*.{css,js}']).on(
        'change',
        bsInstance.reload
    );
});

export const reload = bsInstance.reload;
export default bsInstance;
